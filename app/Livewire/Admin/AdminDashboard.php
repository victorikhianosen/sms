<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;

class AdminDashboard extends Component
{

    #[Title('Admin Dashoard')]
    public function render()
    {
        return view('livewire.admin.admin-dashboard')->extends('layouts.admin_layout')->section('admin-section');
    }
}
