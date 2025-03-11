<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class TransactionList extends Component
{

    use WithPagination;

    public $search = '';
    public $viewModal = false;

    public $ledgerName, $ledgerNumber, $ledgerBalance, $email, $amount, $transaction_type, $balanceBefore, $balanceAfter, $transaction_method, $reference, $status, $date;


    #[Title('Transaction')]
    public function render()
    {
        $transactions = Transaction::latest()
            ->when($this->search, function ($query) {
                $query->whereHas('ledger', function ($q) {
                    $q->where('account_number', 'like', "%{$this->search}%");
                })
                    ->orWhere('amount', 'like', "%{$this->search}%")
                    ->orWhere('status', 'like', "%{$this->search}%")
                    ->orWhere('reference', 'like', "%{$this->search}%")
                    ->orWhere('transaction_type', 'like', "%{$this->search}%")
                    ->orWhereHas('user', function ($q) {
                        $q->where('email', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('admin', function ($q) {
                        $q->where('email', 'like', "%{$this->search}%");
                    });
            })
            ->paginate(10);

        return view('livewire.admin.transaction-list', [
            'transactions' => $transactions
        ])->extends('layouts.admin_layout')->section('admin-section');
    }


    public function closeModal()
    {
        $this->viewModal = false;
    }

    public function viewTransaction($id)
    {
        $this->viewModal = true;
        $transaction = Transaction::find($id);
        if (!$transaction) {
            $this->dispatch('alert', type: 'eror', text: 'An error occured. Please refresh the page.', position: 'center', timer: 10000, button: false);
            return;
        }
        $this->ledgerName =  $transaction->ledger->name;
        $this->ledgerNumber =  $transaction->ledger->account_number;
        $this->ledgerBalance =  $transaction->ledger->balance;
        if ($transaction->user_id && isset($transaction->user)) {
            $this->email = $transaction->user->email;
        } elseif ($transaction->admin_id && isset($transaction->admin)) {
            $this->email = $transaction->admin->email;
        } else {
            $this->email = "Unknown User";
        }
        $this->amount =  $transaction->amount;
        $this->transaction_type = $transaction->transaction_type;
        $this->balanceBefore =  $transaction->balance_before;
        $this->balanceAfter =  $transaction->balance_after;
        $this->transaction_method =  $transaction->method;
        $this->reference =  $transaction->reference;
        $this->status =  $transaction->status;
        $this->date = $transaction->created_at->format('d M Y, h:i A');
    }
}

