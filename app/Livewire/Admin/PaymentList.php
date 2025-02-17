<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class PaymentList extends Component
{
    use WithPagination;

    #[Title('Payment List')]
    public $search = ''; // Livewire search property

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when searching
    }

    public function render()
    {
        $payments = Payment::when($this->search, function ($query) {
            return $query->where('amount', 'like', "%{$this->search}%");
        })->latest()->paginate(1);

        return view('livewire.admin.payment-list', [
            'payments' => $payments,
        ])->extends('layouts.admin_layout')->section('admin-section');
    }
}
