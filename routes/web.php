<?php

use App\Livewire\User\Logs;
use App\Models\Transaction;
use App\Livewire\User\Groups;
use App\Livewire\User\ApiDocs;
use App\Livewire\User\Payment;
use App\Livewire\User\Profile;
use App\Livewire\User\Messages;
use App\Livewire\User\SendBulk;
use App\Livewire\Admin\UserList;
use App\Livewire\Admin\UserView;
use App\Livewire\User\Dashboard;
use App\Livewire\Admin\AdminList;
use App\Livewire\Admin\GroupList;
use App\Livewire\User\Auth\Login;
use App\Livewire\User\EditGroups;
use App\Livewire\User\SendSingle;
use App\Livewire\Admin\LedgerList;
use App\Livewire\User\ScheduleSms;
use App\Livewire\Admin\MessageList;
use App\Livewire\Admin\PaymentList;
use App\Livewire\Admin\UserDetails;
use App\Livewire\Admin\AdminDetails;
use App\Livewire\Admin\AdminSendSms;
use App\Livewire\Admin\SmsRouteList;
use App\Livewire\User\Auth\Register;
use App\Livewire\Admin\SmsSenderList;
use App\Livewire\User\ChangePassword;
use App\Livewire\User\PaymentHistory;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\User\PaystackPayment;
use App\Livewire\User\ScheduleSmsView;
use App\Livewire\Admin\Auth\AdminLogin;
use App\Livewire\Admin\TransactionList;
use App\Livewire\User\Auth\VerifyToken;
use App\Livewire\User\ProcessSinglesms;
use App\Livewire\Admin\AdminMessageList;
use App\Livewire\Admin\AllGeneralLedger;
use App\Livewire\User\Auth\ResetPassword;
use App\Http\Controllers\LogoutController;
use App\Livewire\User\Auth\ForgetPassword;
use App\Livewire\User\BankTransferPayment;
use App\Http\Controllers\PaymentController;
use App\Livewire\Admin\ScheduleMessageList;
use App\Livewire\User\VerifyPaystackPayment;
use App\Http\Controllers\PaystackPaymentController;


Route::get('login', function () {
    return redirect()->route('home');
})->name('login');

Route::get('/', Login::class)->name('home');
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
        // Route::get('paystack', PaystackPayment::class)->name('paystack');
        // Route::get('transfer', BankTransferPayment::class)->name('bank');

        // // Route::get('verify/{reference}', VerifyPaystackPayment::class)->name('verifypayment');
        // Route::get('verify/{reference}', [PaymentController::class, 'verifyPayment'])->name('verifypayment');

        // PaystackPaymentController
        Route::get('history', PaymentHistory::class)->name('history');
    });
    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
});




Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', function() {
        return redirect()->route('admin.login'); // Updated route name
    });
    Route::get('/', AdminLogin::class)->name('login'); // Added name to this route
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard'); 
        Route::get('user/list', UserList::class)->name('userlist');
        Route::get('user/details/{id}', UserDetails::class)->name('userdetails');
        Route::get('logout', [LogoutController::class, 'adminLogout'])->name('logout');
        Route::get('list', AdminList::class)->name(name: 'list');
        Route::get('details/{id}', AdminDetails::class)->name('details');
        Route::get('sender-list', SmsSenderList::class)->name('smssender');
        Route::get('payment-list', PaymentList::class)->name('payment');
        Route::get('message-list', MessageList::class)->name('message');
        Route::get('messges', AdminMessageList::class)->name('adminmessage');

        Route::get('group-list', GroupList::class)->name('group');
        Route::get('sendsms', AdminSendSms::class)->name('sendsms');
        Route::get('schedulelist', ScheduleMessageList::class)->name('schedulelist');
        Route::middleware(['auth:admin', 'super'])->group(function () {
            Route::get('ledger-list', LedgerList::class)->name('ledgers');
            Route::get('transaction-list', TransactionList::class)->name('transactions');
        });


    });


});

