<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\ScheduledMessage;
use App\Services\SendSmsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; // Injecting the service



class SendScheduledMessages extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS messages that are due.';
    protected $smsService;

    public function __construct(SendSmsService $smsService)
    {
        parent::__construct(); // Add this line
        $this->smsService = $smsService;
    }



    public function handle()
    {
        $now = Carbon::now();
        Log::info("Checking for scheduled messages to send at: " . $now);

        $scheduledMessages = ScheduledMessage::where('status', 'pending')->get();

        Log::info("Scheduled messages found: " . $scheduledMessages->count());

        foreach ($scheduledMessages as $scheduled) {
            Log::info("Processing message for User ID: " . $scheduled->user_id);

            $destinations = explode(",", $scheduled->destination); // Convert to array

            foreach ($destinations as $number) {
                $finalPhone = '234' . ltrim(preg_replace('/[^0-9]/', '', trim($number)), '0');
                Log::info("Final phone: " . $finalPhone);
                // Log::info("scheduled Messages: " . $scheduledMessages);
                Log::info("sender: " . $scheduled->sender);
                Log::info("sms_sender_id: " . $scheduled->sms_sender_id);
                Log::info("message: " . $scheduled->message);
                Log::info("amount: " . $scheduled->amount);


                $this->smsService->sendSms(
                    $scheduled->sender,
                    $scheduled->sms_sender_id === 'exchange_trans' ? 'exchange_trans' : 'exchange_pro',
                    $finalPhone,
                    $scheduled->message
                );

                //     Message::create([
                //     'user_id' => $scheduled->user_id,
                //     'sms_sender_id' => $scheduled->sms_sender_id,
                //     'sender' => $scheduled->sender,
                //     'page_number' => $scheduled->sms_unit,
                //     'page_rate' => $scheduled->sms_unit,
                //     'status' => 'sent',
                //     'amount' => $scheduled->amount,
                //     'message' => $scheduled->message,
                //     'message_id' => Str::uuid()->toString(),
                //     'destination' => $finalPhone,
                //     'route' => $scheduled->sms_sender_id === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
                // ]);



                // try {
                // Call sendSms without expecting a response
                // $this->smsService->sendSms(
                //     $scheduled->sender,
                //     $scheduled->sms_sender_id === 'exchange_trans' ? 'exchange_trans' : 'exchange_pro',
                //     $finalPhone,
                //     $scheduled->message
                // );

                // Log success
                // Log::info("SMS sent successfully to: " . $finalPhone);

                // Save to the database
                // Message::create([
                //     'user_id' => $scheduled->user_id,
                //     'sms_sender_id' => $scheduled->sms_sender_id,
                //     'sender' => $scheduled->sender,
                //     'page_number' => $scheduled->sms_unit,
                //     'page_rate' => $scheduled->sms_unit,
                //     'status' => 'sent',
                //     'amount' => $scheduled->amount,
                //     'message' => $scheduled->message,
                //     'message_id' => Str::uuid()->toString(),
                //     'destination' => $finalPhone,
                //     'route' => $scheduled->sms_sender_id === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
                // ]);
                // } catch (\Exception $e) {
                //     Log::error("Error sending SMS to $finalPhone: " . $e->getMessage());
                // }
            }
        }

        $this->info("Scheduled messages processed.");
    }


    // public function handle()
    // {
    //     $now = Carbon::now();

    //     $scheduledMessages = ScheduledMessage::where('status', 'pending')->get();


    //     $now = Carbon::now();

    //     Log::info("Checking for scheduled messages to send at: " . $now); // Log the current time

    //     $scheduleds = ScheduledMessage::where('status', 'pending')->get();

    //     Log::info("Scheduled: " . $scheduleds);
    //     Log::info("Scheduled messages found: " . $scheduleds->count());
    //     // Log::info("Scheduled messages found: " . $scheduled->user_id);

    //     foreach ($scheduleds as $scheduled) {
    //         Log::info("User ID: " . $scheduled->user_id);  // Log the user ID

    //         $user = $scheduled->user_id;
    //         $sender = $scheduled->sender;
    //         $sms_sender_id = $scheduled->sms_sender_id;

    //         $message = $scheduled->message;
    //         $destinations = explode(",", $scheduled->destination);  // Convert string to array
    //         $sms_unit = $scheduled->sms_unit;
    //         $scheduled_time = $scheduled->scheduled_time;
    //         $amount = $scheduled->amount;
    //         $status = $scheduled->status;


    //         $baseURL = env('EXCHANGE_BASEURL');
    //         $username = env($sender === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
    //         $password = env($sender === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
    //         $smsDoc = env('EXCHANGE_SMS_DCS');
    //         $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
    //         $callURL = env('SMS_CALLBACK');



    //         Log::info("destinations " . implode(", ", $destinations));


    //         foreach ($destinations as $number) {


    //             // Remove the leading zero and prepend '234'
    //             $finalPhone = '234' . ltrim(preg_replace('/[^0-9]/', '', trim($number)), '0');
    //             Log::info("finalPhone " . $finalPhone);


    //             $messageID = Str::uuid()->toString();

    //             $url = "$baseURL?X-Service=$username&X-Password=$password&X-Sender={$sender}&X-Recipient=$finalPhone&X-Message={$message}&X-SMS-DCS=$smsDoc&X-External-Id=$enternalID&X-Delivery-URL=$callURL";

    //             $response = Http::get($url);

    //             // Log::info("finalPhone " . $finalPhone);

    //             // Log::info("messageID " . $messageID);

    //             // Log::info("url " . $url);

    //             // Log::info("sender " . $sender);


    //             // $response = Http::get($url);

    //             // Save message details
    //             Message::create([
    //                 'user_id' => $user,
    //                 'sms_sender_id' => $sms_sender_id,
    //                 'sender' => $sender,
    //                 'page_number' => $sms_unit,
    //                 'page_rate' => $sms_unit,
    //                 'status' => 'sent',
    //                 'amount' => $amount,
    //                 'message' => $message,
    //                 'message_id' => $messageID,
    //                 'destination' => $finalPhone,
    //                 'route' => $sender === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
    //             ]);
    //         }



    //     }



    //     $this->info("Scheduled messages processed.");
    // }
}
