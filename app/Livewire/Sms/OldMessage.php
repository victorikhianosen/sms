<?php

namespace App\Livewire\Sms;

use Livewire\Component;
use Livewire\Attributes\Title;

class OldMessage extends Component
{
    #[Title('Old Message')]
    public function render()
    {
        return view('livewire.sms.old-message')->extends('layouts.auth_layout')->section('auth-section');
    }
}
