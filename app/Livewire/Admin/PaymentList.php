<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class PaymentList extends Component
{
    use WithPagination;

    public $email, $amount, $status, $transaction_id, $reference;
    public $bank_name, $account_number, $card_last_four, $card_brand;
    public $currency, $description, $payment_type, $created_at;

    #[Title('Payment List')]
    public $search = '';

    public $editModel = false;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('amount', 'like', $this->search)  // Exact match
                        ->orWhere('amount', 'like', $this->search . '%')  // Starts with
                        ->orWhere('amount', 'like', '%' . $this->search); // Ends with
                });
            })
            ->latest()
            ->paginate(10);

        // dd($payments);

        return view('livewire.admin.payment-list', [
            'payments' => $payments,
        ])->extends('layouts.admin_layout')->section('admin-section');
    }


    public function closeModal()
    {
        $this->editModel = false;
    }

    public function viewPayment($id)
    {
        $this->editModel = true;

        // dd($id);
        $payment = Payment::find($id);
        // dd($payment);
        $this->email = $payment->user->email ?? '';
        $this->amount = $payment->amount;
        $this->status = $payment->status;
        $this->transaction_id = $payment->transaction_id;
        $this->reference = $payment->reference;
        $this->bank_name = $payment->bank_name;
        $this->account_number = $payment->account_number;
        $this->card_last_four = $payment->card_last_four;
        $this->card_brand = $payment->card_brand;
        $this->currency = $payment->currency;
        $this->description = $payment->description;
        $this->payment_type = $payment->payment_type;
        $this->created_at = $payment->created_at->toDateTimeString();

    }
}
