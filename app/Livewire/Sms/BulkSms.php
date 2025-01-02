<?php

namespace App\Livewire\Sms;

use Livewire\Component;
use Livewire\Attributes\Title;

class BulkSms extends Component
{
    #[Title('Bulk')]
    public function render()
    {
        return view('livewire.sms.bulk-sms')->extends('layouts.auth_layout')->section('auth-section');
    }
}
