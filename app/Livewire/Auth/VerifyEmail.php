<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

class VerifyEmail extends Component
{

    #[Title('Verify Email')]
    public function render()
    {
        return view('livewire.auth.verify-email')->extends('layouts.guest_layout')->section('guest-section');
    }
}
