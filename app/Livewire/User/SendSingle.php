<?php

namespace App\Livewire\User;

use App\Models\Credit;
use App\Models\Message;
use Livewire\Component;
use App\Models\Accounts;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class SendSingle extends Component
{
    #[Validate('required')]
    public $sender;

    #[Validate('required')]
    public $message;

    #[Validate('required|digits:11')]
    public $phone_number;

    public $sendersAll;

    public $showModal = false;

    // Validated
    public $totalCharge;
    public $smsUnits;
    public $smsRate;
    public $messageLength;


    #[Title('Messages')]
    public function render()
    {
        $user = Auth::user();
        $this->sendersAll = $user->smssenders;
        return view('livewire.user.send-single')->extends('layouts.auth_layout')->section('auth-section');
    }

    public function previewSMS()
    {
        $validated = $this->validate();

        $user = Auth::user();
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user['balance'];

        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;

        if ($accountBalance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->smsRate = $smsRate;
        $this->totalCharge = $totalCharge;
        $this->messageLength = $messageLength;
        $this->smsUnits = $smsUnits;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;

    }

    public function sendMessage()
    {

        $sender = SmsSender::whereRaw('BINARY name = ?', [$this->sender])->first();
        // dd($sender);
        if (!$sender) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Sender ID', position: 'center', timer: 10000, button: false);
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            $this->dispatch('alert', type: 'error', text: 'unknow sender', position: 'center', timer: 10000, button: false);
        }

        $user = Auth::user();
        $accountBalance = $user['balance'];

        $user->balance = $accountBalance - $this->totalCharge;
        $user->save();


        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('SMS_CALLBACK');

        // Generate a unique message ID
        $messageID = Str::uuid()->toString();
        $finalPhone = '234' . substr($this->phone_number, 1);
        $message = Message::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'page_number' => $this->smsUnits,
            'page_rate' => $this->smsRate,
            'status' => 'sent',
            'amount' => $this->totalCharge,
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

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get($url)->json();


            $this->reset();
            $this->dispatch('alert', type: 'success', text: 'Message sent successfully!', position: 'center', timer: 5000, button: false);
            $this->closeModal();

        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', text: 'Sending failed!', position: 'center', timer: 5000, button: false);
        }

    }
}
