<?php

namespace App\Livewire\User;


use App\Models\Message;
use Livewire\Component;
use App\Models\SmsSender;
use Illuminate\Support\Str;
use App\Jobs\SendBulkSmsJob;
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


    //
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

        return view('livewire.user.send-bulk')->extends('layouts.auth_layout')->section('auth-section');
    }


    public function processBulkMessage()
    {

        // Validate the inputs
        $validated = $this->validate();
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
            return preg_match('/^\d{11}$/', trim($number));  // Ensure number is exactly 11 digits
        });

        $finalNumbers = array_values($finalNumbers);

        if (empty($finalNumbers)) {
            $this->addError('phone_number', 'No phone numbers provided.');
            return;
        }

        $numbersToSend = implode(',', $finalNumbers);

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
        // dd($totalCharge);

        $phoneNumbers = explode(',', str_replace(' ', '', $this->numbersToSend));

        if ($user->balance < ($totalCharge * count($phoneNumbers))) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!. Reduce the phone numbers', position: 'center', timer: 10000, button: false);
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

        $this->showModal = true;
    }


    public function closeModal()
    {
        // Reset modal state and other properties
        $this->showModal = false;
        // $this->resetErrorBag();
        // $this->reset(['sender', 'message', 'phone_number']);
    }





    public function sendBulkMessage()
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

        // Check if user has enough balance
        if ($user->balance < ($totalChargePerSms * count($phoneNumbers))) {
            $this->dispatch('alert', type: 'error', text: 'Insufficient funds!', position: 'center', timer: 10000, button: false);
            return;
        }

        // Environment variables
        $baseURL = env('EXCHANGE_BASEURL');
        $username = env($sender['name'] === 'exchange_trans' ? 'EXCHANGE_TRANS_USERNAME' : 'EXCHANGE_PRO_USERNAME');
        $password = env($sender['name'] === 'exchange_trans' ? 'EXCHANGE_TRANS_PASSWORD' : 'EXCHANGE_PRO_PASSWORD');
        $smsDoc = env('EXCHANGE_SMS_DCS');
        $enternalID = env('EXCHANGE_SMS_ENTERNAL_ID');
        $callURL = env('GGT_CALLBACK');

        foreach ($phoneNumbers as $phoneNumber) {
            // Deduct per SMS charge
            $user->balance -= $totalChargePerSms;
            $user->save();

            // Generate unique message ID
            $messageID = Str::uuid()->toString();

            // Save message to database
            Message::create([
                'user_id' => $user->id,
                'sms_sender_id' => $sender->id,
                'sender' => $sender['name'],
                'page_number' => $smsUnits,
                'page_rate' => $smsRate,
                'status' => 'sent',
                'amount' => $totalChargePerSms,
                'message' => $this->message,
                'message_id' => $messageID,
                'destination' => $phoneNumber,
                'route' => $smsRoute === 'exchange_trans' ? 'EXCH-TRANS' : 'EXCH-PRO',
            ]);

            // Construct the URL for sending the message
            $url = $baseURL .
                '?X-Service=' . urlencode($username) .
                '&X-Password=' . urlencode($password) .
                '&X-Sender=' . urlencode($sender['name']) .
                '&X-Recipient=' . urlencode($phoneNumber) .
                '&X-Message=' . urlencode($this->message) .
                '&X-SMS-DCS=' . urlencode($smsDoc) .
                '&X-External-Id=' . urlencode($enternalID) .
                '&X-Delivery-URL=' . urlencode($callURL);

            try {
                Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->get($url);
            } catch (\Exception $e) {
                // Log error but continue processing
                // Log::error("Failed to send SMS to {$phoneNumber}: " . $e->getMessage());
            }
        }

        $this->dispatch('alert', type: 'success', text: 'Messages sent successfully!', position: 'center', timer: 5000, button: false);
        $this->closeModal();
        $this->reset();
    }
}
