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
    public $searchDateTime = '';
    public $viewModal = false;

    public $ledgerName, $ledgerNumber, $ledgerBalance, $email, $amount, $transaction_type, $balanceBefore, $balanceAfter, $transaction_method, $reference, $status, $date;


    #[Title('Transaction')]


    public function render()
    {
        $transactions = Transaction::query()
            ->when($this->search, function ($query) {
                $searchTerm = "%{$this->search}%";

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('amount', 'like', $searchTerm)
                        ->orWhere('reference', 'like', $searchTerm)
                        ->orWhere('transaction_type', 'like', $searchTerm)
                        ->orWhere('status', 'like', $searchTerm)
                        ->orWhereHas('user', function ($q) use ($searchTerm) {
                            $q->where('email', 'like', $searchTerm);
                        })
                        ->orWhereHas('admin', function ($q) use ($searchTerm) {
                            $q->where('email', 'like', $searchTerm);
                        });
                });
            })
            ->orderBy('created_at', 'desc') // Ensures latest transactions appear first
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
        $this->transaction_method =  $transaction->payment_method;
        $this->reference =  $transaction->reference;
        $this->status =  $transaction->status;
        $this->date = $transaction->created_at->format('d M Y, h:i A');
    }
}
