<?php

namespace App\Livewire\Sms;

use Livewire\Component;
use Livewire\Attributes\Title;

class PaymentSms extends Component
{

    #[Title('SMS Payment')]
    public function render()
    {
        return view('livewire.sms.payment-sms')->extends('layouts.auth_layout')->section('auth-section');
    }
}
