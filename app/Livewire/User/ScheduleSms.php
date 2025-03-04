<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Models\ScheduledMessage;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ScheduleSms extends Component
{
    use WithFileUploads;
    public $allGroups;
    public $sendersAll;

    #[Validate('required')]
    public $sender = null;

    #[Validate('required')]
    public $message;

    #[Validate('required_without:phone_number|nullable')]
    public $group_numbers;

    #[Validate('required_without:group_numbers|nullable')]
    public $phone_number;


    #[Validate('required|date|after_or_equal:now')]
    public $date_time;

    #[Validate('required|max:20')]
    public $description;


    // #[Validate('required')]
    // public $date_time;


    public $showModal = false;


    //
    public $numberCount;
    public $totalCharge;
    public $smsUnits;
    public $numbersToSend;
    public $scheduleTime;

    public $smsRate;
    #[Title('Schedule')]
    public function render()
    {

        $user = Auth::user();
        // $this->allGroups = $user->groups;
        $this->allGroups = $user->groups()->orderBy('created_at', 'desc')->get();
        $this->sendersAll = $user->smssenders;

        return view('livewire.user.schedule-sms')->extends('layouts.auth_layout')->section('auth-section');
    }



    public function processSchedule()
    {
        $validated = $this->validate();

        if (Carbon::parse($validated['date_time'])->lessThan(Carbon::now())) {
            $this->addError('date_time', 'You cannot select a past date or time.');
            return;
        }
        
        $user = Auth::user();
        $finalNumbers = [];

        // dd($validated['date_time']);

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

        // $smsRate = $user->sms_rate;
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

        $this->smsRate =  $smsRate;
        $this->totalCharge = $totalCharge;
        $this->numberCount = $numberCount;
        $this->smsUnits = $smsUnits;
        $this->numbersToSend = $numbersToSend;
        $this->scheduleTime = date("Y-m-d h:i A", strtotime(str_replace('T', ' ', $validated['date_time'])));


        //  dd([
        //     'smsRate' => $smsRate,
        //     'smsCharLimit' => $smsCharLimit,
        //     'smsUnits' => $smsUnits,
        //     'totalCharge' => $totalCharge,
        // ]);

        $this->showModal = true;
    }



    public function sendScheduleMessage()
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

        // dd($smsRoute);

        $user = Auth::user();
        $user->balance -= $this->totalCharge;
        $user->save();

        // Convert the string to an array first before encoding as JSON
        $numbersArray = explode(',', $this->numbersToSend);

        ScheduledMessage::create([
            'user_id' => $user['id'],
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'page_number' => $this->smsUnits,
            'page_rate' => $this->smsRate,
            'amount' => $this->totalCharge,
            'message' => $this->message,
            'description' => $this->description,
            'destination' => json_encode($numbersArray),
            'route' => $smsRoute,  // Now encoding the array as JSON
            'scheduled_time' => Carbon::parse($this->date_time),
        ]);

        $this->reset();
        $this->dispatch('alert', type: 'success', text: "Schedule successfully.", position: 'center', timer: 5000, button: false);
        $this->closeModal();
    }

    public function closeModal()
    {
        // Reset modal state and other properties
        $this->showModal = false;
        // $this->resetErrorBag();
        // $this->reset(['sender', 'message', 'phone_number']);
    }
}
