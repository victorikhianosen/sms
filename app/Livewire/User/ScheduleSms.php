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


    #[Validate('required')]
    public $date_time;


    public $showModal = false;


    //
    public $numberCount;
    public $totalCharge;
    public $smsUnits;
    public $numbersToSend;
    public $scheduleTime;

    #[Title('Schedule')]
    public function render()
    {

        $user = Auth::user();
        $this->allGroups = $user->groups;
        $this->sendersAll = $user->smssenders;

        return view('livewire.user.schedule-sms')->extends('layouts.auth_layout')->section('auth-section');
    }



    public function processSchedule()
    {
        // Validate the inputs
        $validated = $this->validate();

        // dd($this->phone_number);

        $user = Auth::user();

        // Initialize the numbers array
        $finalNumbers = [];

        // Fetch group numbers if a group is selected
        if (!empty($this->group_numbers)) {
            $group = $user->groups()->find($this->group_numbers);
            $groupNumbers = $group ? json_decode($group->numbers, true) : [];
            $finalNumbers = array_merge($finalNumbers, $groupNumbers);
        }

        // Add individual phone numbers if provided
        if (!empty($this->phone_number)) {
            $individualNumbers = explode(',', $this->phone_number); // Convert string to array
            $finalNumbers = array_merge($finalNumbers, $individualNumbers);
        }

        // Remove duplicate numbers
        $finalNumbers = array_unique($finalNumbers);



        $finalNumbers = array_filter($finalNumbers, function ($number) {
            return preg_match('/^\d{11}$/',
                trim($number)
            );  // Ensure number is exactly 11 digits
        });

        $finalNumbers = array_values($finalNumbers);
        // If no numbers are present, throw a validation error
        if (empty($finalNumbers)) {
            $this->addError('phone_number', 'No phone numbers provided.');
            return;
        }

        // Convert numbers back to a comma-separated string
        $numbersToSend = implode(',', $finalNumbers);

        // Converting the numbers string to an array
        $numbersArray = explode(',', $numbersToSend);

        // Assign the count of numbers to a variable
        $numberCount = count($numbersArray);


        // Calculate the sms rate.
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user['balance'];

        $messageLength = strlen($validated['message']);

        $smsUnits = ceil($messageLength / $smsCharLimit);
        $total = $smsUnits * $smsRate;
        $totalCharge = $total * $numberCount;

        $phoneNumbers = explode(',', str_replace(' ', '', $this->numbersToSend));
        if ($user->balance < ($totalCharge * count($phoneNumbers))) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        if ($accountBalance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->totalCharge = $totalCharge;
        $this->numberCount = $numberCount;
        $this->smsUnits = $smsUnits;
        $this->numbersToSend = $numbersToSend;
        $this->scheduleTime = str_replace('T', ' ', $validated['date_time']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        // Reset modal state and other properties
        $this->showModal = false;
        // $this->resetErrorBag();
        // $this->reset(['sender', 'message', 'phone_number']);
    }

    
    public function sendScheduleMessage()
    {
        $phoneNumbers = explode(',', str_replace(' ', '', $this->numbersToSend));

        // Validate sender ID
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
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $messageLength = strlen($this->message);
        $smsUnits = ceil($messageLength / $smsCharLimit);
        $totalChargePerSms = $smsUnits * $smsRate;
        $totalCharge = $totalChargePerSms * count($phoneNumbers);
        // dd($totalCharge);

        // Check if user has enough balance
        if ($user->balance < $totalCharge) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        // Deduct balance
        $user->balance -= $totalCharge;
        $user->save();

        // Save scheduled message
        ScheduledMessage::create([
            'user_id' => $user->id,
            'sms_sender_id' => $sender->id,
            'sender' => $sender['name'],
            'message' => $this->message,
            'destination' => implode(',', $phoneNumbers),
            'sms_units' => $smsUnits,
            'amount' => $totalCharge,
            'scheduled_time' => Carbon::parse($this->scheduleTime),
            'status' => 'pending',
        ]);

        $this->dispatch('alert', type: 'success', text: 'Message scheduled successfully!', position: 'center', timer: 5000, button: false);
        $this->closeModal();
        $this->reset();
    }

}
