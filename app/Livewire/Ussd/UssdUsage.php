<?php

namespace App\Livewire\Ussd;

use Livewire\Component;
use Livewire\Attributes\Title;

class UssdUsage extends Component
{

    #[Title('USSD Usage')]
    public function render()
    {
        return view('livewire.ussd.ussd-usage')->extends('layouts.auth_layout')->section('auth-section');
    }
}
