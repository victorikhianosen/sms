<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
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

        $accountBalance = $admin->balance;

        $admin->balance = $accountBalance - $totalCharge;
        $admin->save();

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env(key: 'EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('SMS_CALLBACK');

        $messageID = Str::uuid()->toString();
        $finalPhone = '234' . substr($this->phone_number, 1);
        $message = Message::create([
            'admin_id' => $admin->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'page_number' => 1,
            'page_rate' => 3,
            'status' => 'sent',
            'amount' => $totalCharge,
            'message' => $this->message,
            'message_id' => $messageID,
            'destination' => $finalPhone,
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);


        $url = $baseURL .
            '?X-Service=' . strval($username) .
            '&X-Password=' . strval($password) .
            '&X-Sender=' . strval($sender['name']) .
            '&X-Recipient=' . strval($finalPhone) .
            '&X-Message=' . strval($this->message) .
            '&X-SMS-DCS=' . strval($smsDoc) .
            '&X-External-Id=' . strval($enternalID) .
            '&X-Delivery-URL=' . strval($callURL);
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get($url)->json();
        $this->reset();
        $this->dispatch('alert', type: 'success', text: 'Message sent successfully!', position: 'center', timer: 5000, button: false);
    }
}
