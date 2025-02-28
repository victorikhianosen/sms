<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $sender;
    protected $message;
    protected $numbersArray;
    protected $smsUnits;
    protected $smsRate;
    protected $totalCharge;

    public function __construct($user, $sender, $message, $numbersArray, $smsUnits, $smsRate, $totalCharge)
    {
        $this->user = $user;
        $this->sender = $sender;
        $this->message = $message;
        $this->numbersArray = $numbersArray;
        $this->smsUnits = $smsUnits;
        $this->smsRate = $smsRate;
        $this->totalCharge = $totalCharge;


        Log::info('SendBulkSmsJob Initialized', [
            'user_id' => $user->id,
            'sender' => $sender->name,
            'message' => $message,
            'numbers_count' => count($numbersArray),
            'sms_units' => $smsUnits,
            'sms_rate' => $smsRate,
            'total_charge' => $totalCharge
        ]);
    }

    public function handle()
    {
        $successfulMessages = 0;
        $failedMessages = 0;
        $smsRoute = $this->sender->smsroute->name;

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('SMS_CALLBACK');

        // Log::info("Page Rate ". $this->smsRate);

        foreach ($this->numbersArray as $number) {
            $finalPhone = '234' . substr(trim($number), 1);
            $messageID = Str::uuid()->toString();

            $url = "$baseURL?X-Service=$username&X-Password=$password&X-Sender={$this->sender->name}&X-Recipient=$finalPhone&X-Message={$this->message}&X-SMS-DCS=$smsDoc&X-External-Id=$enternalID&X-Delivery-URL=$callURL";

            // Send request
            $response = Http::get($url);

            // if ($response->successful()) {
            //     $successfulMessages++;
            // } else {
            //     $failedMessages++;
            // }

            // Save message details
            Message::create([
                'user_id' => $this->user->id,
                'sms_sender_id' => $this->sender->id,
                'sender' => $this->sender->name,
                'page_number' => $this->smsUnits,
                'page_rate' => $this->smsRate,
                'status' => 'sent',
                'amount' => $this->totalCharge / count($this->numbersArray),
                'message' => $this->message,
                'message_id' => $messageID,
                'destination' => $finalPhone,
                'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
            ]);
        }
    }
}



// // Initialize SMS Service
// $smsService = app(SmsService::class);

// // Loop through each number and send SMS
// foreach ($this->numbersArray as $number) {
//     // Format phone number (convert to 234 format)
//     $finalPhone = '234' . substr(trim($number), 1);

//     // Send SMS (No need to store response)
//     $smsService->sendSms($this->sender->name, $this->smsRoute, $finalPhone, $this->message);
// }