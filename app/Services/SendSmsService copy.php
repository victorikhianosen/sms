<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use App\Traits\HttpResponses;
use App\Models\ExchangeWallet;
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


    protected $referenceService;

    public function __construct()
    {
        $this->referenceService = app(ReferenceService::class);
    }


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

        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        $balanceBeforeGL = $ledger->balance;


        $exchange = ExchangeWallet::where('route', $smsRoute)->first();
        if ($exchange['available_unit'] < $smsUnits) {
            return $this->error('Switcher error! Please contact support[U]', 500);
        }
        if ($exchange['available_balance'] < $totalCharge) {
            return $this->error('Switcher error! Please contact support[M]', 500);

        }

        $exchange->available_balance -= $totalCharge;
        $exchange->available_unit -= $smsUnits;
        $exchange->save();
        $user->balance = $accountBalance - $totalCharge;
        $user->save();
        $ledger->balance -= $totalCharge;
        $ledger->save();


        // Generate a unique message ID
        $messageID = Str::uuid()->toString();

        // Format the phone number (assuming Nigerian numbers, for example)
        $phone = $validated['phone_number'];
        $modifiedPhone = substr($phone, 1);
        $finalPhone = '234' . $modifiedPhone;

        $reference = $this->referenceService->generateReference($user);


        $message = $user->messages()->create([
            'sms_sender_id'  => $sender->id,
            'sender'         => $sender->name,
            'page_number'    => $smsUnits,
            'page_rate'      => $smsRate,
            'status'         => 'sent',
            'amount'         => $totalCharge,
            'message'        => $validated['message'],
            'message_reference'     => $messageID,
            'transaction_number' => $reference,
            'destination'    => $validated['phone_number'],
            'route'          => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);


        Transaction::create([
            'user_id' => $user->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $totalCharge,
            'transaction_type' => 'credit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $user->balance,
            'payment_method' => 'api sms',
            'reference' => $message->transaction_number,
            'description' => "SMS Charge (₦ {$totalCharge}) / {$message->transaction_number} / {$message->message_reference} / {$finalPhone}",
            'status' => 'success',
        ]);

        $apiResponse = $this->sendSms(
            $sender->name,
            $smsRoute,
            $finalPhone,
            $validated['message']
        );


        return $this->success(
            [
                'message_ref' => $message->message_reference,
                'phone_number' => $message->destination,
                'sent_at' => $message->created_at->format('Y-m-d H:i:s')
            ],
            'Message sent successfully'
        );
    }



//     public function sendBulk(array $validated)
//     {
//         // return $validated;
// // 
//         // Validate sender
//         return $sender = SmsSender::where('name', $validated['sender'])->first();
//         if (!$sender) {
//             return $this->error('Invalid Sender ID', 500);
//         }

//         // Validate user credentials
//         $user = User::where('api_key', $validated['api_key'])
//             ->where('api_secret', $validated['api_secret'])
//             ->first();

//         // return $user;
//         if (!$user) {
//             return $this->error('Invalid Credentials', 500);
//         }

//         // SMS rate, character limit, and balance check
//         $smsRate = $user->sms_rate;
//         $smsCharLimit = $user->sms_char_limit;
//         $accountBalance = $user->balance;

//         // Split multiple phone numbers
//         $phoneNumbers = explode(',', $validated['phone_number']);
//         $totalCharge = 0;
//         $messages = [];

//         foreach ($phoneNumbers as $phone) {
//             $phone = trim($phone);
//             // if (!preg_match('/^070|080|081|090|091[0-9]{8}$/', $phone)) {
//             //     continue; // Skip invalid numbers
//             // }

//             // Calculate cost per message
//             $messageLength = strlen($validated['message']);
//             $smsUnits = ceil($messageLength / $smsCharLimit);
//             $charge = $smsUnits * $smsRate;
//             $totalCharge += $charge;

//             if ($accountBalance < $totalCharge) {
//                 return $this->error('Insufficient funds', 500);
//             }

//             // Format phone number
//             $finalPhone = '234' . substr($phone, 1);

//             // Send SMS
//             $apiResponse = $this->sendSms(
//                 $sender->name,
//                 $sender->smsroute->name,
//                 $finalPhone,
//                 $validated['message']
//             );

//             // Save to database
//             $message = $user->messages()->create([
//                 'sms_sender_id'  => $sender->id,
//                 'sender'         => $sender->name,
//                 'page_number'    => $smsUnits,
//                 'page_rate'      => $smsRate,
//                 'status'         => 'sent',
//                 'amount'         => $charge,
//                 'message'        => $validated['message'],
//                 'destination'    => $phone,
//             ]);

//             $messages[] = [
//                 'message_ref'  => $message->id,
//                 'phone_number' => $phone,
//                 'status'       => 'sent',
//             ];
//         }

//         // Deduct balance
//         $user->balance -= $totalCharge;
//         $user->save();

//         return $this->success($messages, 'Bulk SMS sent successfully');
//     }



    public function sendSms(string $senderName, string $smsRoute, string $finalPhone, string $message): ?array
    {
        $baseURL     = env('EXCHANGE_BASEURL');
        $username    = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password    = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc      = env('EXCHANGE_SMS_DCS');
        $externalID  = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callbackURL = env('EXCHANGE_CALLBACK');

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

        // Log::info($url, $baseURL);

        // Log::info('SMS Request', [
        //     'timestamp'  => now()->toDateTimeString(),
        //     'url'        => $url,
        //     'parameters' => [
        //         'senderName' => $senderName,
        //         'smsRoute'   => $smsRoute,
        //         'finalPhone' => $finalPhone,
        //         'message'    => $message,
        //     ]
        // ]);

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
