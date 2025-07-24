<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendSmsService;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\SendSmsRequest;
use App\Http\Requests\SendBulkRequest;

class SendSMSController extends Controller
{

    private $sendSmsService;

    public function __construct(SendSmsService $sendSmsService)
    {
        $this->sendSmsService = $sendSmsService;
    }
    public function sendSMS(SendSmsRequest $request)
    {
        $validated = $request->validated();
        return $sms =  $this->sendSmsService->send($validated);
    }


    public function sendBulk(SendBulkRequest $request)
    {
        $validated = $request->validated();
        // return $sms =  $this->sendSmsService->sendBulk($validated);
    }

    // ftp
    // smstrix
    // z!7WB4Wf5BRg

// FTP Username: smstrix@sms.assetmatrixmfb.com
// FTP server: ftp.sms.assetmatrixmfb.com
// FTP & explicit FTPS port:  21


    // Don't Delete The below API
    // return $response = Http::get('http://197.210.194.184/fcgi-bin/jar_http_sai.fcgi?X-Service=ggttxmt&X-Password=mtggtrx&X-Sender=LAPO MFB&X-Recipient=2347033274155&X-Message=Your Login verification Code is XXXXXX. It expires in 20 minutes. Thanks for using LAPO MFB.&X-SMS-DCS=0&X-External-Id=YJlzSNW7OoPT99XxoGwZ&X-Delivery-URL=https://api.shapley.tech/tg/v1/webhook/checker')->json();


    // http://197.210.194.184/fcgi-bin/jar_http_sai.fcgi?X-Service=ggttxmt&X-Password=mtggtrx&X-Sender=AssetMatrix&X-Recipient=2349046594124&X-Message=Testing.&X-SMS-DCS=0&X-External-Id=YJlzSNW7OoPT99XxoGwZ&X-Delivery-URL=https://sms.assetmatrixmfb.com/callback

    // http://197.210.194.184/fcgi-bin/jar_http_sai.fcgi?X-Service=ggttxmt&X-Password=mtggtrx&X-Sender=LAPO MFB&X-Recipient=2347033274155&X-Message=Your Login verification Code is XXXXXX. It expires in 20 minutes. Thanks for using LAPO MFB.&X-SMS-DCS=0&X-External-Id=YJlzSNW7OoPT99XxoGwZ&X-Delivery-URL=https://api.shapley.tech/tg/v1/webhook/checker


    // $baseURL = env('EXCHANGE_BASEURL');
    // $username = env('EXCHANGE_TRANS_USERNAME');
    // $password = env('EXCHANGE_TRANS_PASSWORD');

    // $smsDoc = env('EXCHANGE_SMS_DCS');
    // $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
    // $callURL = env('SMS_CALLBACK');

    // $url = $baseURL .
    //     '?X-Service=' . urlencode($username).
    //     '&X-Password=' . urlencode($password) .
    //     '&X-Sender=PROPERTY NG' .
    //     '&X-Recipient=' . urlencode($recipient) .
    //     '&X-Message=' . urlencode($message) .
    //     '&X-SMS-DCS=0' .
    //     '&X-External-Id=' . urlencode($enternalID) .
    //     '&X-Delivery-URL=' . urlencode($callURL);

    // // Call the API
    // $response = Http::withHeaders([
    //     'Accept' => 'application/json',
    //     'Content-Type' => 'application/json',
    // ])->get($url);

    // return $response->json();
}
