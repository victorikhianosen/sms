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

    public function sendSMS(Request $request)
    {
        $validated = $request->validate([
            'api_key' => 'required',
            'api_secret' => 'required',
            'sender'   => 'required',
            'phone_number' => 'required|numeric|digits:11',
            'message'  => 'required',
        ]);
        return $sms =  $this->sendSmsService->send($validated);
    }

    public function sendBulk(SendBulkRequest $request)
    {
        $validated = $request->validated();
    }
}
