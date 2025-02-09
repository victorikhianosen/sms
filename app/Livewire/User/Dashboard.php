<?php

namespace App\Livewire\User;

use App\Models\Group;
use App\Models\Credit;
use App\Models\Message;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Dashboard extends Component
{

    public $accountBalance;

    public $allPayment;

    public $allGroups;

    public $groupCount;

    public $messageCount;

    public $allMessage;


    public function mount() {

        // $userID = Auth::id();

        //    $this->allGroups = Group::where('user_id', $userID)
        //     ->get();
        // $this->groupCount = $this->allGroups->count();
        // dd($this->allGroups, $this->groupCount);
    }

    #[Title('Dashboard')]
    public function render()
    {

        return view('livewire.user.dashboard')->extends('layouts.auth_layout')->section('auth-section');
    }


    public function getBalance()
    {
        $user = Auth::user();
        $this->accountBalance = $user['balance'];
    }


    public function getAllGroups()
    {
        $userID = Auth::id();

        $this->allGroups = Group::where('user_id', $userID)
            ->get();
        $this->groupCount = $this->allGroups->count();
        // dd($this->allGroups, $this->groupCount);

    }

    public function allRecentPayment()
    {
        $userID =  Auth::id();

        $this->allPayment = Payment::where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

            // dd($this->allPayment);
    }


    public function getRecentMessage()
    {

        $userID =  Auth::id();
        $this->allMessage = Message::where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

                    $this->messageCount = $this->allMessage->count();
    }


}
