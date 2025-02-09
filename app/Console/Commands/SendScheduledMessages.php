<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Support\Str;
use App\Services\LogService;
use Illuminate\Console\Command;
use App\Models\ScheduledMessage;
use App\Services\SendSmsService;

class SendScheduledMessages extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS messages that are due.';
    protected $smsService;

    public function __construct(SendSmsService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    public function handle()
    {
        $now = Carbon::now();
        LogService::scheduleSms("Checking for scheduled messages to send at: " . $now);

        // $scheduledMessages = ScheduledMessage::where('status', 'pending')->get();
        $scheduledMessages = ScheduledMessage::where('status', 'pending')
        ->whereTime('scheduled_time', '<=', $now) // Compare time only
        ->get();


        LogService::scheduleSms("Pending Scheduled messages found: " . $scheduledMessages->count());

        foreach ($scheduledMessages as $scheduled) {
            LogService::scheduleSms("Processing message for User ID: " . $scheduled->user_id);

            $destinations = explode(",", $scheduled->destination); // Convert to array
            $numRecipients = count($destinations); // Get the number of recipients

            if ($numRecipients === 0) {
                LogService::scheduleSms("No valid recipients found for scheduled message ID: " . $scheduled->id);
                continue;
            }

            $messageLength = strlen($scheduled->message); // Get the total characters in message
            $pageNumber = ceil($messageLength / 150); // Each page contains 150 characters

            // Ensure $scheduled->amount is not zero to avoid division by zero
            $totalAmount = max($scheduled->amount, 0);
            $amountPerRecipient = $totalAmount / $numRecipients;
            $totalChargePerRecipient = $pageNumber * $scheduled->page_rate; // Charge per recipient

            foreach ($destinations as $number) {
                $finalPhone = '234' . ltrim(preg_replace('/[^0-9]/', '', trim($number)), '0');
                LogService::scheduleSms("Final phone: " . $finalPhone);

                // Sending SMS (commented out for now)
                $this->smsService->sendSms(
                    $scheduled->sender,
                    $scheduled->sms_sender_id === 'exchange_trans' ? 'exchange_trans' : 'exchange_pro',
                    $finalPhone,
                    $scheduled->message
                );

                // Saving message details
                Message::create([
                    'user_id' => $scheduled->user_id,
                    'sms_sender_id' => $scheduled->sms_sender_id,
                    'sender' => $scheduled->sender,
                    'page_number' => $pageNumber,
                    'page_rate' => $scheduled->page_rate,
                    'status' => 'sent',
                    'amount' => min($amountPerRecipient, $totalChargePerRecipient), // Amount deducted per recipient
                    'message' => $scheduled->message,
                    'message_id' => Str::uuid()->toString(),
                    'destination' => $finalPhone,
                    'route' => $scheduled->sms_sender_id === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
                ]);
                $scheduled->update(['status' => 'sent']);


                LogService::scheduleSms("scheduled message: " . "====================");

            }
        }

        $this->info("Scheduled messages processed.");
    }
}
