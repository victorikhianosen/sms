<?php

use App\Livewire\User\Logs;
use App\Livewire\User\Groups;
use App\Livewire\User\ApiDocs;
use App\Livewire\User\Payment;
use App\Livewire\User\Profile;
use App\Livewire\User\Messages;
use App\Livewire\User\SendBulk;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Auth\Login;
use App\Livewire\User\EditGroups;
use App\Livewire\User\SendSingle;
use App\Livewire\Admin\AdminLogin;
use App\Livewire\User\ScheduleSms;
use App\Livewire\User\Auth\Register;
use App\Livewire\User\ChangePassword;
use App\Livewire\User\PaymentHistory;
use Illuminate\Support\Facades\Route;
use App\Livewire\User\PaystackPayment;
use App\Livewire\User\ScheduleSmsView;
use App\Livewire\User\Auth\VerifyToken;
use App\Livewire\User\ProcessSinglesms;
use App\Livewire\User\Auth\ResetPassword;
use App\Http\Controllers\LogoutController;
use App\Livewire\User\Auth\ForgetPassword;
use App\Livewire\User\BankTransferPayment;
use App\Http\Controllers\PaymentController;
use App\Livewire\User\VerifyPaystackPayment;
use App\Http\Controllers\PaystackPaymentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');



Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');

Route::get('forget-password', ForgetPassword::class)->name('forgetpassword');

Route::get('verify-token/{email}', VerifyToken::class)->name('verifytoken');

Route::get('reset-password/{email}', ResetPassword::class)->name('resetpassword');




// Authenticated routes (require user to be logged in)
Route::middleware(['auth'])->group(function () {

    Route::prefix('sms')->group(function () {

        Route::prefix('single')->group(function () {
            Route::get('', SendSingle::class)->name('single');
        });


        Route::get('bulk', SendBulk::class)->name('bulk');
        Route::get('schedule', ScheduleSms::class)->name('schedule');
        Route::get('schedule-view', ScheduleSmsView::class)->name('schedule.view');
    });


    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('message', Messages::class)->name('message');

    Route::get('apidocs', ApiDocs::class)->name('apidocs');

    Route::get('profile', Profile::class)->name('profile');
    Route::get('change-password', ChangePassword::class)->name('changepassword');



    Route::get('logs', Logs::class)->name('logs');
    Route::get('groups', Groups::class)->name('groups');
    Route::get('groups/{id}', EditGroups::class)->name('editgroups');

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('paystack', PaystackPayment::class)->name('paystack');
        Route::get('transfer', BankTransferPayment::class)->name('bank');

        // Route::get('verify/{reference}', VerifyPaystackPayment::class)->name('verifypayment');
        Route::get('verify/{reference}', [PaymentController::class, 'verifyPayment'])->name('verifypayment');

        // PaystackPaymentController
        Route::get('history', PaymentHistory::class)->name('history');
    });

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
});




// Admin Login Route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', AdminLogin::class)->name('login');
});