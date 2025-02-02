<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

class BankTransferPayment extends Component
{
    #[Validate('required|numeric')]
    public $amount;

    public $formattedAmount = '';
    public $units = '';
    public $formattedUnits = ''; // Formatted units

    #[Title('Bank Transfer')]

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
}
