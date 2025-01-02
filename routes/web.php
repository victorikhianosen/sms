<?php

use App\Http\Controllers\LogoutController;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Sms\BulkSms;
use App\Livewire\Sms\Message;
use App\Livewire\Auth\Register;
use App\Livewire\Sms\SingleSms;
use App\Livewire\Sms\OldMessage;
use App\Livewire\Sms\PaymentSms;
use App\Livewire\Ussd\UssdUsage;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Ussd\UssdPayment;
use App\Livewire\Ussd\UssdShortcode;
use App\Livewire\Auth\ForgetPassword;
use App\Livewire\Ussd\UssdLogs;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');
Route::get('forget-password', ForgetPassword::class)->name('forget.password');
Route::get('verify', VerifyEmail::class)->name('verify.email');


Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', Dashboard::class)->name('dashboard');

    
    // SMS
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::get('single', SingleSms::class)->name('single');
        Route::get('bulk', BulkSms::class)->name('bulk');
        Route::get('message', Message::class)->name('message');
        Route::get('old-message', OldMessage::class)->name('old');
        Route::get('payment', PaymentSms::class)->name('payment');
    });


    // USSD
    Route::prefix('ussd')->name('ussd.')->group(function () {
        Route::get('usage', UssdUsage::class)->name('usage');
        Route::get('shortcode', UssdShortcode::class)->name('shortcode');
        Route::get('payment', UssdPayment::class)->name('payment');
        Route::get('logs', UssdLogs::class)->name('logs');
    });

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
});
