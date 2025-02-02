<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\ScheduledMessage;
use Illuminate\Support\Facades\Http;

class SendScheduledMessages extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS messages that are due.';

    public function handle()
    {
        $now = Carbon::now();

        $scheduledMessages = ScheduledMessage::where('status', 'pending')
            ->where('scheduled_time', '<=', $now)
            ->get();

        foreach ($scheduledMessages as $sms) {
            $user = $sms->user;
            $sender = $sms->smsSender;

            $phoneNumbers = explode(',', $sms->destination);

            $baseURL = env('EXCHANGE_BASEURL');
            $username = env($sender->name === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
            $password = env($sender->name === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
            $smsDoc = env('EXCHANGE_SMS_DCS');
            $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
            $callURL = env('GGT_CALLBACK');

            foreach ($phoneNumbers as $phoneNumber) {
                try {
                    $messageID = Str::uuid()->toString();

                    Message::create([
                        'user_id' => $user->id,
                        'sms_sender_id' => $sender->id,
                        'sender' => $sender->name,
                        'page_number' => $sms->sms_units,
                        'page_rate' => $sms->amount / count($phoneNumbers),
                        'status' => 'sent',
                        'amount' => $sms->amount / count($phoneNumbers),
                        'message' => $sms->message,
                        'message_id' => $messageID,
                        'destination' => $phoneNumber,
                        'route' => $sender->smsroute->name === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
                    ]);

                    $url = $baseURL .
                        '?X-Service=' . urlencode($username) .
                        '&X-Password=' . urlencode($password) .
                        '&X-Sender=' . urlencode($sender->name) .
                        '&X-Recipient=' . urlencode($phoneNumber) .
                        '&X-Message=' . urlencode($sms->message) .
                        '&X-SMS-DCS=' . urlencode($smsDoc) .
                        '&X-External-Id=' . urlencode($enternalID) .
                        '&X-Delivery-URL=' . urlencode($callURL);

                    Http::get($url);

                    // Update scheduled message status
                    $sms->update(['status' => 'sent']);
                } catch (\Exception $e) {
                    $sms->update(['status' => 'failed']);
                }
            }
        }

        $this->info("Scheduled messages processed.");
    }
}
