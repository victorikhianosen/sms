<?php

namespace App\Livewire\Ussd;

use Livewire\Component;
use Livewire\Attributes\Title;

class UssdPayment extends Component
{
    #[Title('USSD Payment')]
    public function render()
    {
        return view('livewire.ussd.ussd-payment')->extends('layouts.auth_layout')->section('auth-section');
    }
}
