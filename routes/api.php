<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FakeSMSController;
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\CallBackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/sendsms', [SendSMSController::class,'sendSMS']);
Route::post('/sendbulk', [SendSMSController::class, 'sendBulk']);
Route::post('/callback', [CallBackController::class, 'callback']);
Route::post('/matrixcallback', [CallBackController::class, 'matrixCallback']);
// Route::post('/matrixcallback', function () {
//     return 'Victpr';
// });





