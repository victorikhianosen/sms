<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;
use App\Services\SendSmsService;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

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
    public $totalCharge;
    public $smsUnits;
    public $smsRate;
    public $messageLength;

    protected $sendSmsService;

    public function __construct()
    {
        $this->sendSmsService = app(SendSmsService::class);
    }

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
        // $smsRate = $user->sms_rate;
        // $smsCharLimit = $user->sms_char_limit;
        $smsRate = (float) $user->sms_rate;

        if (!$smsRate) { 
            $this->dispatch('alert', type: 'error', text: 'Sorry, your rate has not been fixed.', position: 'center', timer: 10000, button: false);
            return;
        }
        
        $smsCharLimit = (int) $user->sms_char_limit;
        $accountBalance = $user['balance'];
        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate;

        // dd([
        //     'smsRate' => $smsRate,
        //     'smsCharLimit' => $smsCharLimit,
        //     'smsUnits' => $smsUnits,
        //     'totalCharge' => $totalCharge,
        // ]);

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
        if (!$sender) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Sender ID', position: 'center', timer: 10000, button: false);
            return;
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            $this->dispatch('alert', type: 'error', text: 'Unknown sender', position: 'center', timer: 10000, button: false);
            return;
        }

        $user = Auth::user();
        $user->balance -= $this->totalCharge;
        $user->save();

        $finalPhone = '234' . substr($this->phone_number, 1);
        $messageID = Str::uuid()->toString();

        Message::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender->name,
            'page_number' => $this->smsUnits,
            'page_rate' => $this->smsRate,
            'status' => 'sent',
            'amount' => $this->totalCharge,
            'message' => $this->message,
            'message_id' => $messageID,
            'destination' => $finalPhone,
            'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
        ]);

        $reference = $this->generateReference($user);


        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Error in fetching Ledger.', position: 'center', timer: 5000);
            return;
        }

        $balanceBeforeGL = $ledger->balance;

        $ledger->balance += $this->totalCharge;
        $ledger->save();

        Transaction::create([
            'user_id' => $user->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $this->totalCharge,
            'transaction_type' => 'credit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $user->balance,
            'method' => 'manual',
            'reference' => $reference,
            'description' => "Funds added by admin (₦" . number_format($this->totalCharge, 2) . ")",
            'status' => 'success',
        ]);

        $response = $this->sendSmsService->sendSms($sender->name, $smsRoute, $finalPhone, $this->message);
        $this->dispatch('alert', type: 'success', text: 'Message sent successfully!', position: 'center', timer: 5000, button: false);
        $this->closeModal();
        $this->reset(['sender','message', 'phone_number']);
    }


    private function generateReference($data)
    {
        $adminID = $data['id'];
        $firstTwoFirstName = strtoupper(substr($data->first_name, 0, 2));
        $firstTwoLastName = strtoupper(substr($data->last_name, 0, 2));
        $firstThreeDigits = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
        $fourLetters = strtoupper(Str::random(4));
        $sevenDigitNumber = random_int(100000, 999999);
        $lastThreeLetters = ucfirst(Str::random(2)) . 'C';

        return "{$firstThreeDigits}{$fourLetters}{$sevenDigitNumber}{$lastThreeLetters}{$adminID}{$firstTwoFirstName}{$firstTwoLastName}/MAN";
    }
}
