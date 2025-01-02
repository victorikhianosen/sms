<?php

namespace App\Livewire\Sms;

use Livewire\Component;
use Livewire\Attributes\Title;

class SingleSms extends Component
{

    #[Title('Single')]
    public function render()
    {
        return view('livewire.sms.single-sms')->extends('layouts.auth_layout')->section('auth-section');
    }
}
