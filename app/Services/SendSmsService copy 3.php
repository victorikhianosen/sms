<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use App\Models\SmsRoute;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Http;

class SendSmsService
{
    use HttpResponses;



    public function send($validated)
    {
        // Get the sender from the database
        $sender = SmsSender::whereRaw('BINARY name = ?', [$validated['sender']])->first();
        if (!$sender) {
            return $this->error('Invalid Sender ID', 500);
        }
        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            return $this->error('Unknown Sender', 500);
        }

        // Get the user from the API credentials
        $user = User::where('api_key', '=', $validated['api_key'])
            ->where('api_secret', $validated['api_secret'])->first();
        if (!$user) {
            return $this->error('Invalid Credentials', 500);
        }

        // SMS rate and character limit
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user['balance'];

        // Calculate message length and cost
        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;

        // Check if the user has sufficient funds
        if ($accountBalance < $totalCharge) {
            return $this->error('Insufficient funds', 500);
        }

        // Deduct the balance and save the user
        $user->balance = $accountBalance - $totalCharge;
        $user->save();

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('SMS_CALLBACK');

        $messageID = Str::uuid()->toString();


        $phone = $validated['phone'];

        $modifiedPhone = substr($phone, 1);

        $finalPhone = '234' . $modifiedPhone;

        $message = Message::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'page_number' => $smsUnits,
            'page_rate' => $smsRate,
            'status' => 'sent',
            'amount' => $totalCharge,
            'message' => $finalPhone,
            'message_id' => $messageID,
            'destination' => $validated['phone'],
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        $url = $baseURL .
            '?X-Service=' . strval($username) .
            '&X-Password=' . strval($password) .
            '&X-Sender=' . strval($sender['name']) .
            '&X-Recipient=' . strval($finalPhone) .
            '&X-Message=' . strval($validated['message']) .
            '&X-SMS-DCS=' . strval($smsDoc) .
            '&X-External-Id=' . strval($enternalID) .
            '&X-Delivery-URL=' . strval($callURL);
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url)->json();

            // return $response;
            return $this->success([
                'message_id' => $messageID
            ], 'Message sent successfully');
        } catch (\Exception $e) {
            return $this->error('An error occurred while sending the message', 500);
        }
    }
}
