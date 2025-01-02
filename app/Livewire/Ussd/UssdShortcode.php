<?php

namespace App\Livewire\Ussd;

use Livewire\Component;
use Livewire\Attributes\Title;

class UssdShortcode extends Component
{
    #[Title('USSD Short Code')]
    public function render()
    {
        return view('livewire.ussd.ussd-shortcode')->extends('layouts.auth_layout')->section('auth-section');
    }
}
