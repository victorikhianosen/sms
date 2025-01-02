<?php

namespace App\Livewire\Sms;

use Livewire\Component;
use Livewire\Attributes\Title;

class Message extends Component
{

    #[Title('Message')]
    public function render()
    {
        return view('livewire.sms.message')->extends('layouts.auth_layout')->section('auth-section');
    }
}
