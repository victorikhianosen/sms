<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Jobs\ProcessBulkSms;
use App\Models\GeneralLedger;
use Livewire\WithFileUploads;
use App\Models\ExchangeWallet;
use Livewire\Attributes\Title;
use App\Services\SendSmsService;
use Livewire\Attributes\Validate;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class SendBulk extends Component
{
    use WithFileUploads;

    // public $allGroups = [];
    // public $sendersAll;

    #[Validate('required')]
    public $sender = null;

    #[Validate('required')]
    public $message;

    #[Validate('required_without:phone_number|nullable')]
    public $group_numbers;

    #[Validate('required_without:group_numbers|nullable')]
    public $phone_number;

    public $showModal = false;
    public $numberCount;
    public $totalCharge;
    public $smsUnits;
    public $numbersToSend;
    public $messageLength;
    public $smsRate;

    protected $sendSmsService;
    protected $referenceService;

    public function __construct()
    {
        $this->sendSmsService = app(SendSmsService::class);
        $this->referenceService = app(ReferenceService::class);
    }


    #[Title('Bulk')]
    public function render()
    {
        $user = Auth::user();
        $allGroups = $user->groups()->orderBy('created_at', 'desc')->get();
        $sendersAll = $user->smssenders;

        return view('livewire.user.send-bulk', compact('allGroups', 'sendersAll'))
            ->extends('layouts.auth_layout')
            ->section('auth-section');
    }

    public function processBulkMessage()
    {
        $validated = $this->validate();
        $user = Auth::user();
        $finalNumbers = [];

        if (!empty($this->group_numbers)) {
            $group = $user->groups()->find($this->group_numbers);
            $groupNumbers = $group ? json_decode($group->numbers, true) : [];
            $finalNumbers = array_merge($finalNumbers, $groupNumbers);
        }

        if (!empty($this->phone_number)) {
            $individualNumbers = explode(',', $this->phone_number);
            $finalNumbers = array_merge($finalNumbers, $individualNumbers);
        }

        $finalNumbers = array_unique($finalNumbers);
        $finalNumbers = array_filter($finalNumbers, function ($number) {
            return preg_match('/^\d{11}$/', trim($number));
        });

        $finalNumbers = array_values($finalNumbers);
        if (empty($finalNumbers)) {
            $this->addError('phone_number', 'No valid phone numbers provided.');
            return;
        }

        $numbersToSend = implode(',', $finalNumbers);
        $numbersArray = explode(',', $numbersToSend);
        $numberCount = count($numbersArray);

        $smsRate = (float) $user->sms_rate;

        if (!$smsRate) {
            $this->dispatch('alert', type: 'error', text: 'Sorry, your rate has not been fixed. Contact support.', position: 'center', timer: 10000, button: false);
            return;
        }

        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user->balance;
        $messageLength = strlen($validated['message']);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalCharge = $smsUnits * $smsRate * $numberCount;

        if ($accountBalance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->totalCharge = $totalCharge;
        $this->numberCount = $numberCount;
        $this->smsUnits = $smsUnits;
        $this->numbersToSend = $numbersToSend;
        $this->showModal = true;
        $this->smsRate = $smsRate;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }



    public function sendBulkMessage()
    {
        if (!$this->numbersToSend) {
            $this->dispatch('alert', type: 'error', text: 'No numbers found!', position: 'center', timer: 5000, button: false);
            return;
        }

        $sender = SmsSender::whereRaw('BINARY name = ?', [$this->sender])->first();
        if (!$sender) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Sender ID', position: 'center', timer: 5000, button: false);
            return;
        }

        $smsRoute = $sender->smsroute->name;
        if (!in_array($smsRoute, ['exchange_trans', 'exchange_pro'])) {
            $this->dispatch('alert', type: 'error', text: 'Unknown sender', position: 'center', timer: 10000, button: false);
            return;
        }

        $user = Auth::user();
        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Unable to process your request at the moment. Please contact support.[GL]', position: 'center', timer: 5000);
            return;
        }

        $exchange = ExchangeWallet::where('route', $smsRoute)->first();
        if ($exchange['available_unit'] < $this->smsUnits) {
            $this->dispatch('alert', type: 'error', text: 'Switcher error! Please contact support[U].', position: 'center', timer: 5000);
            return;
        }
        if ($exchange['available_balance'] < $this->totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Switcher error! Please contact support[M].', position: 'center', timer: 5000);
            return;
        }

        $exchange->available_balance -= $this->totalCharge;
        $exchange->available_unit -= $this->smsUnits;
        $exchange->save();

        ProcessBulkSms::dispatch(
            $user->id,
            $sender->id,
            $sender->name,
            $smsRoute,
            $this->numbersToSend,
            $this->message,
            $this->smsUnits,
            $this->smsRate,
            $this->totalCharge,
            $ledger->id
        );

        $this->reset();
        $this->dispatch('alert', type: 'success', text: 'Bulk messages sent successfully!', position: 'center', timer: 5000, button: false);
        $this->closeModal();
    }

}