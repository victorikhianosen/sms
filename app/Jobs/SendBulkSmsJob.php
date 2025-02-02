<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumbers;
    protected $message;
    protected $sender;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct($phoneNumbers, $message, $sender, $user)
    {
        $this->phoneNumbers = $phoneNumbers;
        $this->message = $message;
        $this->sender = $sender;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $smsRate = $this->user->sms_rate;
        $smsCharLimit = $this->user->sms_char_limit;
        $messageLength = strlen($this->message);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalChargePerSms = $smsUnits * $smsRate;

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($this->sender['name'] === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($this->sender['name'] === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('GGT_CALLBACK');

        foreach ($this->phoneNumbers as $phoneNumber) {
            // Deduct balance per SMS
            $this->user->balance -= $totalChargePerSms;
            $this->user->save();

            // Save message record
            Message::create([
                'user_id' => $this->user->id,
                'sms_sender_id' => $this->sender->id,
                'sender' => $this->sender['name'],
                'page_number' => $smsUnits,
                'page_rate' => $smsRate,
                'status' => 'sent',
                'amount' => $totalChargePerSms,
                'message' => $this->message,
                'message_id' => Str::uuid()->toString(),
                'destination' => $phoneNumber,
                'route' => $this->sender->smsroute->name === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
            ]);

            // Construct SMS URL
            $url = $baseURL .
                '?X-Service=' . urlencode($username) .
                '&X-Password=' . urlencode($password) .
                '&X-Sender=' . urlencode($this->sender['name']) .
                '&X-Recipient=' . urlencode($phoneNumber) .
                '&X-Message=' . urlencode($this->message) .
                '&X-SMS-DCS=' . urlencode($smsDoc) .
                '&X-External-Id=' . urlencode($enternalID) .
                '&X-Delivery-URL=' . urlencode($callURL);

            try {
                Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->get($url);
            } catch (\Exception $e) {
                // Log error but continue
            }
        }
    }
}
