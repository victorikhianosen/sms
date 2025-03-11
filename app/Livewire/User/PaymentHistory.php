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
    public $search = '';

    #[Title('Payment History')]
    public function render()
    {
        $userID = Auth::id();
        $allPayment = Payment::where('user_id', $userID)
            // ->orderBy('created_at', 'desc')
            // ->paginate(10);
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('admin', function ($query) { // Search by admin email too
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('amount', 'like', $this->search)
                        ->orWhere('amount', 'like', $this->search . '%')
                        ->orWhere('amount', 'like', '%' . $this->search);
                });
            })
            ->latest()
            ->paginate(perPage: 10);


        return view('livewire.user.payment-history', compact('allPayment'))
            ->extends('layouts.auth_layout')
            ->section('auth-section');
    }
}
