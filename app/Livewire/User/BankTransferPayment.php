<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class BankTransferPayment extends Component
{
    #[Validate('required|numeric')]
    public $amount;

    public $formattedAmount = '';
    public $units = '';
    public $formattedUnits = ''; // Formatted units

    public $firstName;
    public $lastName;
    public $accountNumber;


    #[Title('Bank Transfer')]


    public function mount() {
        $user = Auth::user();
        // dd($user);
        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->accountNumber = $user['account_number'];

        // dd($this->accountNumber);
    }

    public function render()
    {
        return view('livewire.user.bank-transfer-payment')->extends('layouts.auth_layout')->section('auth-section');
    }

    // Livewire listener for triggering the alert
    protected $listeners = ['alert'];

    public function alert($data)
    {
        // Dispatch the browser event for alert
        $this->dispatch('swal', $data);
    }


//     {
//     "accountName": "demo test",
//     "accountNumber": "1011011111",
//     "amount": "100",
//     "tranxfee": "10",
//     "narration": "inward success",
//     "sessionId": "3245368368373983638368362127336392",
//     "sourceAccountNumber": "1111000067",
//     "sourceAccountName": "demom demo"
// }
}
