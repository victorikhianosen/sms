<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use App\Models\ExchangeWallet;
use Livewire\Attributes\Title;
use App\Services\SendSmsService;
use Livewire\Attributes\Validate;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;

class SendSingle extends Component
{
    #[Validate('required')]
    public $sender;

    #[Validate('required')]
    public $message;

    #[Validate('required|digits:11')]
    public $phone_number;

    public $sendersAll;
    public $showModal = false;
    public $totalCharge;
    public $smsUnits;
    public $smsRate;
    public $messageLength;

    protected $sendSmsService;
    protected $referenceService;


    public function __construct()
    {
        $this->sendSmsService = app(SendSmsService::class);
        $this->referenceService = app(ReferenceService::class);
    }

    #[Title('Messages')]
    public function render()
    {
        $user = Auth::user();
        $this->sendersAll = $user->smssenders;
        return view('livewire.user.send-single')->extends('layouts.auth_layout')->section('auth-section');
    }


    public function previewSMS()
    {
        $validated = $this->validate();

        $user = Auth::user();

        $smsRate = (float) $user->sms_rate;

        if (!$smsRate) {
            $this->dispatch('alert', type: 'error', text: 'Sorry, your rate has not been fixed.', position: 'center', timer: 10000, button: false);
            return;
        }

        $smsCharLimit = (int) $user->sms_char_limit;
        $accountBalance = $user['balance'];
        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;



        if ($accountBalance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->smsRate = $smsRate;
        $this->totalCharge = $totalCharge;
        $this->messageLength = $messageLength;
        $this->smsUnits = $smsUnits;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function sendMessage()
    {
        $sender = SmsSender::whereRaw('BINARY name = ?', [$this->sender])->first();
        if (!$sender) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Sender ID', position: 'center', timer: 10000, button: false);
            return;
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            $this->dispatch('alert', type: 'error', text: 'Unknown sender', position: 'center', timer: 10000, button: false);
            return;
        }

        $user = Auth::user();
        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Unable to process your request at the moment. Please contact support.', position: 'center', timer: 5000);
            return;
        }

        $exchange = ExchangeWallet::where('route', $smsRoute)->first();

        if ($exchange['available_unit'] < $this->smsUnits) {
            $this->dispatch('alert', type: 'error', text: 'Switcher error! Please contact support[U].', position: 'center', timer: 5000);
            return;
        }

        if ($exchange['available_balance'] < $this->totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Switcher error! Please contact support[M].', position: 'center', timer: 5000);
            return;
        }

        $balanceBeforeGL = $ledger->balance;
        $user->balance -= $this->totalCharge;
        $user->save();

        $ledger->balance -= $this->totalCharge;
        $ledger->save();

        $exchange->available_balance -= $this->totalCharge;
        $exchange->available_unit -= $this->smsUnits;
        $exchange->save();

        $finalPhone = '234' . substr($this->phone_number, 1);
        $message_reference = str_replace('-', '', Str::uuid()->toString());

        $transaction_number = $this->referenceService->generateReference($user);

        $user->messages()->create([
            'sms_sender_id' => $sender->id,
            'sender' => $sender->name,
            'page_number' => $this->smsUnits,
            'page_rate' => $this->smsRate,
            'status' => 'sent',
            'amount' => $this->totalCharge,
            'message' => $this->message,
            'message_reference' => $message_reference,
            'transaction_number' => $transaction_number,
            'destination' => $finalPhone,
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $this->totalCharge,
            'transaction_type' => 'credit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $ledger->balance,
            'payment_method' => 'single sms',
            'reference' => $transaction_number,
            'description' => "SMS Charge (₦ {$this->totalCharge}) / {$transaction_number} / {$message_reference} / {$finalPhone}",
            'status' => 'success',
        ]);


        $activeProvider = $this->sendSmsService->getActiveSmsProvider();


        if ($activeProvider === 'africa_is_talking') {
            $response = $this->sendSmsService->africaIsTalking($sender->name, $finalPhone, $this->message, $message_reference);
        } elseif ($activeProvider === 'exchange') {
            $response = $this->sendSmsService->sendSms(
                $sender->name,
                $smsRoute,
                $finalPhone,
                $this->message,
                $message_reference
            );
        } else {
            $this->dispatch('alert', type: 'error', text: 'No active SMS provider configured.', position: 'center', timer: 5000);
            return;
        }

        // dd($response);
        $this->dispatch('alert', type: 'success', text: 'Message sent successfully!', position: 'center', timer: 5000, button: false);
        $this->closeModal();
        $this->reset(['sender', 'message', 'phone_number']);
    }
}
