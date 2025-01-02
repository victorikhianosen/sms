<?php

namespace App\Livewire\Ussd;

use Livewire\Component;
use Livewire\Attributes\Title;

class UssdLogs extends Component
{
    #[Title('USSD Logs')]
    public function render()
    {
        return view('livewire.ussd.ussd-logs')->extends('layouts.auth_layout')->section('auth-section');
    }
}
