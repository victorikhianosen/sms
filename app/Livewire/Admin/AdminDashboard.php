<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Group;
use App\Models\Message;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Title;

class AdminDashboard extends Component
{
    public $messageCount;
    public $dashboardBalance;

    public $allAdminBalance;
    public $totalAccountBalance;


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
        $this->allAdminBalance = Admin::sum( 'balance');

        $this->totalAccountBalance = $this->dashboardBalance + $this->allAdminBalance;



        // $this->allUserBalance = User::sum(column: 'balance');
        // $this->allAdminBalance = Admin::sum(column: 'balance');
        // $this->ledgerBalance = GeneralLedger::sum('balance');
        // $this->totalBalance = $this->allUserBalance + $this->allAdminBalance;
        // // dd($this->allUserBalance, $this->allAdminBalance, $this->totalBalance);
        // $admins = Auth::guard('admin')->user();
        // $this->first_name = $admins->first_name;
        // $this->balance = $admins->balance;
    }

    public function AdminRecentMessage()
    {

        $this->allAdminMessage = Message::latest()->limit(6)->get();
    }


}
