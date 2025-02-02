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
        $sender = SmsSender::whereRaw('BINARY name = ?', [$validated['sender']])->first();
        if (!$sender) {
            return $this->error('Invalid Sender ID', 500);
        }
        $smsRoute = $sender->smsroute->name;

        if ($smsRoute === 'exchange_trans') {
            return $this->transactional($validated);
        } elseif ($smsRoute === 'exchange_pro') {
            return $this->promotional($validated);

        } else {
            return $this->error('Unknow Sender', 500);
        }


    }

    public function transactional($validated)
    {

        $user = User::where('api_key', '=', $validated['api_key'])
        ->where('api_secret', $validated['api_secret'])->first();

        $sender = SmsSender::whereRaw('BINARY name = ?', [$validated['sender']])->first();
        if (!$user) {
            return $this->error('Invalid Credentials', 500);
        }

        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;

        $accountBalance = $user['balance'];

        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;

        if ($accountBalance < $totalCharge) {
            return $this->error('Insufficient funds', 500);
        }

        $user->balance = $accountBalance - $totalCharge;
        $user->save();

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env('EXCHANGE_TRANS_USERNAME');
        $password = env('EXCHANGE_TRANS_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('GGT_CALLBACK');


        $messageID = Str::uuid()->toString();



        $message = Message::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'page_number' => $smsUnits,
            'page_rate' => $smsRate,
            'status' => 'pending',
            'amount' => $totalCharge,
            'message' => $validated['message'],
            'message_id' => $messageID,
            'destination' => $validated['phone'],
            'route' => 'EXCH-PRO',
        ]);

        // return $validated;

        $url = $baseURL .
            '?X-Service=' . urlencode($username) .
            '&X-Password=' . urlencode($password) .
            '&X-Sender=' . urlencode($sender['name']) .
            '&X-Recipient=' . urlencode($validated['phone']) .
            '&X-Message=' . urlencode($validated['message']) .
            '&X-SMS-DCS=' . urlencode($smsDoc) .
            '&X-External-Id=' . urlencode($enternalID) .
            '&X-Delivery-URL=' . urlencode($callURL);;

        // return $url;
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url);

            if ($response->successful()) {
                return $this->success($messageID, 'Message sent successfully');
            }
            return $this->error('Failed to send message. Please try again later.', 500);
        } catch (\Exception $e) {
            return $this->error('An error occurred while sending the message', 500);
        }

    }


    public function promotional($validated)
    {

        $user = User::where('api_key', '=', $validated['api_key'])
            ->where('api_secret', $validated['api_secret'])->first();

        $sender = SmsSender::whereRaw('BINARY name = ?', [$validated['sender']])->first();
        if (!$user) {
            return $this->error('Invalid Credentials', 500);
        }

        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;

        $accountBalance = $user['balance'];

        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;

        if ($accountBalance < $totalCharge) {
            return $this->error('Insufficient funds', 500);
        }

        $user->balance = $accountBalance - $totalCharge;
        $user->save();

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env('EXCHANGE_PRO_USERNAME');
        $password = env('EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('GGT_CALLBACK');


        $messageID = Str::uuid()->toString();



        $message = Message::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id, // This stores the sender's ID
            'sender' => $sender['name'],
            'page_number' => $smsUnits,
            'page_rate' => $smsRate,
            'status' => 'pending',
            'amount' => $totalCharge,
            'message' => $validated['message'],
            'message_id' => $messageID,
            'destination' => $validated['phone'],
            'route' => 'EXCH-PRO',
        ]);

        // return $validated;

        $url = $baseURL .
            '?X-Service=' . urlencode($username) .
            '&X-Password=' . urlencode($password) .
            '&X-Sender=' . urlencode($sender['name']) .
            '&X-Recipient=' . urlencode($validated['phone']) .
            '&X-Message=' . urlencode($validated['message']) .
            '&X-SMS-DCS=' . urlencode($smsDoc) .
            '&X-External-Id=' . urlencode($enternalID) .
            '&X-Delivery-URL=' . urlencode($callURL);;

            return $url;
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url);

            if ($response->successful()) {
                return $this->success($messageID,'Message sent successfully');
            }
            return $this->error('Failed to send message. Please try again later.', 500);
        } catch (\Exception $e) {
            return $this->error('An error occurred while sending the message', 500);

        }
    }
}
