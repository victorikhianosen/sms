<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::post('sendsms', [SendSMSController::class, 'send']);
Route::post('send-sms', [SmsController::class, 'sendSms']);
