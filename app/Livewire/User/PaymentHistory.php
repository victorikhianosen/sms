<?php

namespace App\Livewire\User;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class PaymentHistory extends Component
{
    use WithPagination;

    public $showModal = false;

    #[Title('Payment History')]
    public function render()
    {
        $userID = Auth::id();
        $allPayment = Payment::where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.payment-history', compact('allPayment'))
            ->extends('layouts.auth_layout')
            ->section('auth-section');
    }
}
