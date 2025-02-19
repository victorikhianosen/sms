<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Title;

class AdminDashboard extends Component
{
    public $messageCount;
    public $dashboardBalance;
    public $groupCount;
    public $paymentCount;
    public $allAdminMessage = [];

    public $AdminRecentPayment = [];




    #[Title('Admin Dashoard')]
    public function render()
    {
        return view('livewire.admin.admin-dashboard')->extends('layouts.admin_layout')->section('admin-section');
    }

    public function AdminGetDetails()
    {

        $this->messageCount = Message::count();
        $this->groupCount = Group::count();
        $this->paymentCount = Payment::count();
        $this->dashboardBalance = User::sum('balance');
    }

    public function AdminRecentMessage()
    {

        $this->allAdminMessage = Message::latest()->limit(6)->get();
    }


}
