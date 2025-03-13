<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;
use App\Services\SendSmsService;
use Livewire\Attributes\Validate;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminSendSms extends Component
{
    public $allSender = [];

    #[Validate('required')]
    public $sender;
    #[Validate('required|min:2|max:140')]
    public $message;
    #[Validate('required|digits:11')]
    public $phone_number;



    protected $sendSmsService;
    protected $referenceService;


    public function __construct()
    {
        $this->sendSmsService = app(SendSmsService::class);
        $this->referenceService = app(ReferenceService::class);
    }
    
    public function mount()
    {
        $this->allSender = SmsSender::all();
    }

    #[Title('Group List')]
    public function render()
    {
        return view('livewire.admin.admin-send-sms')->extends('layouts.admin_layout')->section('admin-section');
    }

    public function Sendsms()
    {
        $validate = $this->validate();

        $admin = Auth::guard('admin')->user();
        // dd($admin);

        $totalCharge = 3;

        if ($admin->balance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds', position: 'center', timer: 10000, button: false);
            return;
        }

        $sender = SmsSender::whereRaw('BINARY name = ?', [$this->sender])->first();

        if (!$sender) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Sender ID', position: 'center', timer: 10000, button: false);
            return;
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            $this->dispatch('alert', type: 'error', text: 'unknow sender', position: 'center', timer: 10000, button: false);
            return;
        }

        $admin = Auth::guard('admin')->user();


        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Unable to process your request at the moment. Please contact support.', position: 'center', timer: 5000);
            return;
        }

        $balanceBeforeGL = $ledger->balance;
        $accountBalance = $admin->balance;
        $admin->balance = $accountBalance - $totalCharge;
        $admin->save();

        $ledger->balance -= $totalCharge;
        $ledger->save();

        $message_reference = Str::uuid()->toString();

        $transaction_number = $this->referenceService->generateReference($admin);
        // dd(vars: $transaction_number);

        Message::create([
            'sms_sender_id' => $sender->id,
            'admin_id' => $admin->id,
            'sender' => $sender->name,
            'page_number' => '1',
            'page_rate' => $admin->sms_rate,
            'status' => 'sent',
            'amount' => $totalCharge,
            'message' => $this->message,
            'message_reference' => $message_reference,
            'transaction_number' => $transaction_number,
            'destination' => $this->phone_number,
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);
        
        Transaction::create([
            'admin_id' => $admin->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $totalCharge,
            'transaction_type' => 'credit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $ledger->balance,
            'payment_method' => 'SAS',
            'reference' => $transaction_number,
            'description' => "SMS Charge (₦ {$totalCharge}) / {$admin->transaction_number} / {admin->$message_reference} / {$admin->phone_number}",
            'status' => 'success',
        ]);

        $response = $this->sendSmsService->sendSms($sender->name, $smsRoute, $this->phone_number, $this->message);
        $this->dispatch('alert', type: 'success', text: 'Message sent successfully!', position: 'center', timer: 5000, button: false);
        $this->reset(['sender', 'message', 'phone_number']);
    }
}
