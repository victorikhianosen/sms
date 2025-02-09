<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SendBulk extends Component
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

    public $showModal = false;
    public $numberCount;
    public $totalCharge;
    public $smsUnits;
    public $numbersToSend;
    public $messageLength;
    public $smsRate;

    #[Title('Bulk')]
    public function render()
    {
        $user = Auth::user();
        $this->allGroups = $user->groups;
        $this->sendersAll = $user->smssenders;

        return view('livewire.user.send-bulk')
            ->extends('layouts.auth_layout')
            ->section('auth-section');
    }

    public function processBulkMessage()
    {
        $validated = $this->validate();
        $user = Auth::user();
        $finalNumbers = [];

        // Fetch group numbers if a group is selected
        if (!empty($this->group_numbers)) {
            $group = $user->groups()->find($this->group_numbers);
            $groupNumbers = $group ? json_decode($group->numbers, true) : [];
            $finalNumbers = array_merge($finalNumbers, $groupNumbers);
        }

        // Add individual phone numbers if provided
        if (!empty($this->phone_number)) {
            $individualNumbers = explode(',', $this->phone_number);
            $finalNumbers = array_merge($finalNumbers, $individualNumbers);
        }

        // Remove duplicates and validate numbers
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

        // Calculate SMS cost
        $smsRate = $user->sms_rate;
        $smsCharLimit = $user->sms_char_limit;
        $accountBalance = $user['balance'];
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
            $this->dispatch('alert', type: 'error', text: 'Unknown sender', position: 'center', timer: 5000, button: false);
            return;
        }

        $user = Auth::user();
        $user->balance -= $this->totalCharge;
        $user->save();

        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($smsRoute === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('SMS_CALLBACK');

        $numbersArray = explode(',', $this->numbersToSend);
        $successfulMessages = 0;
        $failedMessages = 0;

        foreach ($numbersArray as $number) {
            $finalPhone = '234' . substr(trim($number), 1);
            $messageID = Str::uuid()->toString();

            $url = $baseURL .
                '?X-Service=' . strval($username) .
                '&X-Password=' . strval($password) .
                '&X-Sender=' . strval($sender['name']) .
                '&X-Recipient=' . strval($finalPhone) .
                '&X-Message=' . strval($this->message) .
                '&X-SMS-DCS=' . strval($smsDoc) .
                '&X-External-Id=' . strval($enternalID) .
                '&X-Delivery-URL=' . strval($callURL);

            // Send request
            $response = Http::get($url);
            if ($response->successful()) {
                $successfulMessages++;
            } else {
                $failedMessages++;
            }

            // Save the message details
            Message::create([
                'user_id' => $user->id,
                'sms_sender_id' => $sender->id,
                'sender' => $sender['name'],
                'page_number' => $this->smsUnits,
                'page_rate' => $this->smsRate,
                'status' => $response->successful() ? 'sent' : 'failed',
                'amount' => $this->totalCharge / count($numbersArray),
                'message' => $this->message,
                'message_id' => $messageID,
                'destination' => $finalPhone,
                'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
            ]);
        }

        $this->reset();
        $this->dispatch('alert', type: 'success', text: "Messages Sent: $successfulMessages | Failed: $failedMessages", position: 'center', timer: 5000, button: false);
        $this->closeModal();
    }
}
