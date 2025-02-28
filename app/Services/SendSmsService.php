<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SendSmsService
{
    use HttpResponses;

    /**
     * Sends an SMS message.
     *
     * @param array $validated Data containing api_key, api_secret, sender, message, and phone.
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(array $validated)
    {

        // return $validated;
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
        $user = User::where('api_key', $validated['api_key'])
            ->where('api_secret', $validated['api_secret'])
            ->first();
        if (!$user) {
            return $this->error('Invalid Credentials', 500);
        }

        // SMS rate and character limit
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user->balance;

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

        // Generate a unique message ID
        $messageID = Str::uuid()->toString();

        // Format the phone number (assuming Nigerian numbers, for example)
        $phone = $validated['phone'];
        $modifiedPhone = substr($phone, 1);
        $finalPhone = '234' . $modifiedPhone;

        // Create a record for the message in the database
        Message::create([
            'user_id'        => $user->id,
            'sms_sender_id'  => $sender->id,
            'sender'         => $sender->name,
            'page_number'    => $smsUnits,
            'page_rate'      => $smsRate,
            'status'         => 'sent',
            'amount'         => $totalCharge,
            'message'        => $validated['message'],
            'message_id'     => $messageID,
            'destination'    => $validated['phone'],
            'route'          => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        // Send the SMS via the external provider using dynamic values
        $apiResponse = $this->sendSms(
            $sender->name,
            $smsRoute,
            $finalPhone,
            $validated['message']
        );


        return $this->success(
            ['message_id' => $messageID],
            'Message sent successfully'
        );
    }

    /**
     * Sends the SMS message to the external provider.
     *
     * Only the sender, smsRoute, message, and phone are dynamic; the remaining values are loaded from environment variables.
     *
     * @param string $senderName
     * @param string $smsRoute
     * @param string $finalPhone
     * @param string $message
     * @return array|null
     */
    


    public function sendSms(string $senderName, string $smsRoute, string $finalPhone, string $message): ?array
    {
        $baseURL     = env('EXCHANGE_BASEURL');
        $username    = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password    = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc      = env('EXCHANGE_SMS_DCS');
        $externalID  = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callbackURL = env('SMS_CALLBACK');

        $url = sprintf(
            '%s?X-Service=%s&X-Password=%s&X-Sender=%s&X-Recipient=%s&X-Message=%s&X-SMS-DCS=%s&X-External-Id=%s&X-Delivery-URL=%s',
            $baseURL,
            $username,
            $password,
            $senderName,
            $finalPhone,
            $message,
            $smsDoc,
            $externalID,
            $callbackURL
        );

        try {
            $response = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url)->json();

            return $response; // ✅ Return API response
        } catch (\Exception $e) {
            Log::error("SMS API Error: " . $e->getMessage());
            return null; // ✅ Explicitly return null in case of failure
        }
    }

}


