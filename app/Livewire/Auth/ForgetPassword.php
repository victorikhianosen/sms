<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

class ForgetPassword extends Component
{
    #[Title('Forget Password')]
    public function render()
    {
        return view('livewire.auth.forget-password')->extends('layouts.guest_layout')->section('guest-section');
    }
}
