<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use Illuminate\Bus\Queueable;
use App\Services\SendSmsService;
use App\Services\ReferenceService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessBulkSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $senderId;
    protected $senderName;
    protected $smsRoute;
    protected $numbersToSend;
    protected $message;
    protected $smsUnits;
    protected $smsRate;
    protected $totalCharge;
    protected $ledgerId;

    /**
     * Create a new job instance.
     */
    public function __construct(
        $userId,
        $senderId,
        $senderName,
        $smsRoute,
        $numbersToSend,
        $message,
        $smsUnits,
        $smsRate,
        $totalCharge,
        $ledgerId
    ) {
        $this->userId = $userId;
        $this->senderId = $senderId;
        $this->senderName = $senderName;
        $this->smsRoute = $smsRoute;
        $this->numbersToSend = $numbersToSend;
        $this->message = $message;
        $this->smsUnits = $smsUnits;
        $this->smsRate = $smsRate;
        $this->totalCharge = $totalCharge;
        $this->ledgerId = $ledgerId;
    }

    /**
     * Execute the job.
     */
    public function handle(SendSmsService $sendSmsService, ReferenceService $referenceService)
    {

        $activeProvider = $sendSmsService->getActiveSmsProvider();

        $user = User::find($this->userId);
        $ledger = GeneralLedger::find($this->ledgerId);
        $route = $this->smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO';

        $numbersArray = explode(',', $this->numbersToSend);
        $chargePerMessage = $this->totalCharge / count($numbersArray);

        foreach ($numbersArray as $number) {
            $number = trim($number);
            if (empty($number)) {
                continue;
            }

            $balanceBeforeGL = $ledger->balance;

            $user->balance -= $chargePerMessage;
            $user->save();
            $ledger->balance -= $chargePerMessage;
            $ledger->save();

            $finalPhone = '234' . substr($number, 1);
            $message_reference = str_replace('-', '', Str::uuid()->toString());
            $transaction_number = $referenceService->generateReference($user);

            $user->messages()->create([
                'sms_sender_id' => $this->senderId,
                'sender' => $this->senderName,
                'page_number' => $this->smsUnits,
                'page_rate' => $this->smsRate,
                'status' => 'sent',
                'amount' => $chargePerMessage,
                'message' => $this->message,
                'message_reference' => $message_reference,
                'transaction_number' => $transaction_number,
                'destination' => $finalPhone,
                'route' => $route,
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'general_ledger_id' => $ledger->id,
                'amount' => $chargePerMessage,
                'transaction_type' => 'credit',
                'balance_before' => $balanceBeforeGL,
                'balance_after' => $ledger->balance,
                'payment_method' => 'bulk sms',
                'reference' => $transaction_number,
                'description' => "SMS Charge (₦ {$chargePerMessage}) / {$transaction_number} / {$finalPhone}",
                'status' => 'success',
            ]);

            if ($activeProvider === 'africa_is_talking') {
                $sendSmsService->africaIsTalking($this->senderName, $finalPhone, $this->message, $message_reference);
            } elseif ($activeProvider === 'exchange') {
                $sendSmsService->sendSms($this->senderName, $this->smsRoute, $finalPhone, $this->message, $message_reference);
            } else {
                // Optional: Log or notify for debugging
                logger()->error('No active SMS provider configured for bulk SMS dispatch.');
            }





            // $sendSmsService->sendSms($this->senderName, $this->smsRoute, $finalPhone, $this->message, $message_reference);
        }
    }
}
