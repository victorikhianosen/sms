<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;

class Logs extends Component
{

    #[Title('Logs')]
    public function render()
    {
        return view('livewire.user.logs')->extends('layouts.auth_layout')->section('auth-section');
    }
}
