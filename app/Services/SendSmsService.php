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

        // Get environment variables for SMS API integration
        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('GGT_CALLBACK');

        // Generate a unique message ID
        $messageID = Str::uuid()->toString();

        // Save the message details to the database
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
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        // Construct the URL for sending the message
        $url = $baseURL .
            '?X-Service=' . urlencode($username) .
            '&X-Password=' . urlencode($password) .
            '&X-Sender=' . urlencode($sender['name']) .
            '&X-Recipient=' . urlencode($validated['phone']) .
            '&X-Message=' . urlencode($validated['message']) .
            '&X-SMS-DCS=' . urlencode($smsDoc) .
            '&X-External-Id=' . urlencode($enternalID) .
            '&X-Delivery-URL=' . urlencode($callURL);

        // Send the SMS via HTTP request
        
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
}
