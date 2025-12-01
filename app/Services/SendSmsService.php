<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use App\Models\SmsSender;
use App\Models\SmsProvider;
use App\Models\Transaction;
use App\Models\GeneralLedger;
use App\Models\ExchangeWallet;
use App\Traits\HttpResponses;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SendSmsService
{
    use HttpResponses;

    protected $referenceService;

    public function __construct()
    {
        $this->referenceService = app(ReferenceService::class);
    }

    public function getActiveSmsProvider()
    {
        return SmsProvider::where('is_active', true)->value('slug');
    }


    public function send(array $validated)
    {
        $sender = SmsSender::whereRaw('BINARY name = ?', [$validated['sender']])->first();
        if (!$sender) {
            return $this->error('Invalid Sender ID', 500);
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            return $this->error('Unknown Sender', 500);
        }

        $user = User::where('api_key', $validated['api_key'])
            ->where('api_secret', $validated['api_secret'])
            ->first();
        if (!$user) {
            return $this->error('Invalid Credentials', 500);
        }

        $smsRate       = $user->sms_rate;
        $smsCharLimit  = $user->sms_char_limit;
        $accountBalance = $user->balance;

        $messageLength = strlen($validated['message']);
        $smsUnits      = ceil($messageLength / $smsCharLimit);
        $totalCharge   = $smsUnits * $smsRate;

        if ($accountBalance < $totalCharge) {
            return $this->error('Insufficient funds', 500);
        }

        $ledger   = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        $exchange = ExchangeWallet::where('route', $smsRoute)->first();

        if ($exchange['available_unit'] < $smsUnits) {
            return $this->error('Switcher error! Please contact support[U]', 500);
        }

        if ($exchange['available_balance'] < $totalCharge) {
            return $this->error('Switcher error! Please contact support[M]', 500);
        }

        $balanceBeforeGL = $ledger->balance;

        $user->balance -= $totalCharge;
        $user->save();

        $ledger->balance -= $totalCharge;
        $ledger->save();

        $exchange->available_balance -= $totalCharge;
        $exchange->available_unit   -= $smsUnits;
        $exchange->save();

        $message_reference = str_replace('-', '', Str::uuid()->toString());

        $phone        = $validated['phone_number'];
        $modifiedPhone = substr($phone, 1); 
        $finalPhone    = '234' . $modifiedPhone;

        $reference = $this->referenceService->generateReference($user);

        $message = $user->messages()->create([
            'sms_sender_id'      => $sender->id,
            'sender'             => $sender->name,
            'page_number'        => $smsUnits,
            'page_rate'          => $smsRate,
            'status'             => 'sent',
            'amount'             => $totalCharge,
            'message'            => $validated['message'],
            'message_reference'  => $message_reference,
            'transaction_number' => $reference,
            'destination'        => $validated['phone_number'],
            'route'              => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        Transaction::create([
            'user_id'           => $user->id,
            'general_ledger_id' => $ledger->id,
            'amount'            => $totalCharge,
            'transaction_type'  => 'credit',
            'balance_before'    => $balanceBeforeGL,
            'balance_after'     => $user->balance,
            'payment_method'    => 'api sms',
            'reference'         => $message->transaction_number,
            'description'       => "SMS Charge (₦ {$totalCharge}) / {$message->transaction_number} / {$message->message_reference} / {$finalPhone}",
            'status'            => 'success',
        ]);

        $activeProvider = $this->getActiveSmsProvider();

        if (!$activeProvider) {
            return $this->error('No active SMS provider configured.', 404);
        }

        $smsService = $this;
        app()->terminating(function () use (
            $smsService,
            $activeProvider,
            $sender,
            $smsRoute,
            $finalPhone,
            $validated,
            $message_reference
        ) {
            try {
                if ($activeProvider === 'africa_is_talking') {
                    $smsService->africaIsTalking(
                        $sender->name,
                        $finalPhone,
                        $validated['message'],
                        $message_reference
                    );
                } elseif ($activeProvider === 'exchange') {
                    $smsService->sendSms(
                        $sender->name,
                        $smsRoute,
                        $finalPhone,
                        $validated['message'],
                        $message_reference
                    );
                } elseif ($activeProvider === 'evexin') {
                    $smsService->evexin(
                        $sender->name,
                        $finalPhone,
                        $validated['message'],
                        $message_reference
                    );
                }

                Log::info('Async SMS provider call completed', [
                    'provider'          => $activeProvider,
                    'message_reference' => $message_reference,
                    'phone'             => $finalPhone,
                ]);
            } catch (\Throwable $e) {
                Log::error('Async SMS provider call failed', [
                    'provider'          => $activeProvider,
                    'message_reference' => $message_reference,
                    'phone'             => $finalPhone,
                    'error'             => $e->getMessage(),
                ]);
            }
        });

        Log::info('SMS API response sent to client (async mode)', [
            'message_reference' => $message_reference,
            'phone'             => $finalPhone,
            'provider'          => $activeProvider,
        ]);
        return $this->success(
          
            'Message sent sucessfully',
              [
                'phone_number' => $message->destination,
                'sent_at'      => $message->created_at->format('Y-m-d H:i:s'),
            ],
        );
    }

    public function sendSms(string $senderName, string $smsRoute, string $finalPhone, string $message, $message_reference): ?array
    {
        $baseURL   = env('EXCHANGE_BASEURL');
        $username  = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password  = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc    = env('EXCHANGE_SMS_DCS');
        $externalID = $message_reference;
        $callbackURL = 'https://sms.assetmatrixmfb.com/api/callback';

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

        $data = [
            'timestamp'  => now()->toDateTimeString(),
            'url'        => $url,
            'parameters' => [
                'senderName' => $senderName,
                'smsRoute'   => $smsRoute,
                'finalPhone' => $finalPhone,
                'message'    => $message,
            ],
        ];

        Log::info('SMS Request', $data);

        try {
            $response = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url)->json();

            return $response;
        } catch (\Exception $e) {
            Log::error("SMS API Error: " . $e->getMessage());
            return null;
        }
    }

    public function africaIsTalking($senderId, $phones, $message, $reference)
    {
        if (!is_array($phones)) {
            $phones = [$phones];
        }

        $formattedPhones = array_map(function ($phone) {
            $phone = trim($phone);
            if (!str_starts_with($phone, '+')) {
                $phone = '+' . $phone;
            }
            return $phone;
        }, $phones);

        $aitBaseUrl = env('AIT_BASE_URL');
        $aitApiKey  = env('AIT_API_KEY');
        $username   = env('AIT_USERNAME');

        $response = Http::withHeaders([
            'Accept'      => 'application/json',
            'Content-Type'=> 'application/json',
            'apiKey'      => $aitApiKey,
        ])->post($aitBaseUrl, [
            'username'    => $username,
            'message'     => $message,
            // 'senderId'  => $senderId, // if supported
            'phoneNumbers'=> $formattedPhones,
        ])->json();

        Log::info('AfricaIsTalking Response', $response ?? []);

        $recipient    = $response['SMSMessageData']['Recipients'][0] ?? null;
        $aitMessageId = $response['SMSMessageData']['Recipients'][0]['messageId'] ?? null;

        if ($recipient && isset($recipient['statusCode'], $recipient['status'])) {
            if ($recipient['statusCode'] === 100 && $recipient['status'] === 'Success') {
                $messageModel = Message::where('message_reference', $reference)->first();
                if ($messageModel) {
                    $messageModel->update([
                        'message_reference' => $aitMessageId,
                    ]);
                }
            }
        }
    }

    public function evexin($senderId, $phones, $message, $reference)
    {
        if (!is_array($phones)) {
            $phones = [$phones];
        }

        $formattedPhones = array_map(function ($phone) {
            $phone = trim($phone);
            $phone = ltrim($phone, '+');
            return $phone;
        }, $phones);

        $phone = count($formattedPhones) === 1
            ? $formattedPhones[0]
            : $formattedPhones;

        $baseUrl   = env('EVEXIN_BASE_URL');
        $appKey    = env('EVEXIN_APP_KEY');
        $appSecret = env('EVEXIN_APP_SECRET');

        $payload = [
            'content'              => $message,
            'to'                   => $phone,
            'senderCode'           => 'AssetMatrix',
            'shortLinkReplaceFlag' => 'N',
        ];

        Log::info('Evexin API Payload', $payload);

        $response = Http::withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'appKey'       => $appKey,
            'appSecret'    => $appSecret,
        ])->post($baseUrl . "/api/msg/v2/sendMsg", $payload);

        Log::info('Evexin API Response', $response->json());

    }
}
