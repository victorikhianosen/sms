<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Exchange;
use Livewire\WithPagination;
use App\Models\ExchangeWallet;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class ExchangeList extends Component
{
    use WithPagination;

    public $fundModel = false;

    public $name, $username, $available_balance;
    public $amount;
    public $exchangeId;

    #[Title('Exchange')]
    public function render()
    {
        return view('livewire.admin.exchange-list', [
            'exchanges' => ExchangeWallet::latest()->paginate(10)
        ])->extends('layouts.admin_layout')->section('admin-section');
    }

    public function closeModal() {
        $this->fundModel = false;
    }

    public function showAddFund($id) {
        $this->fundModel = true;
        $exchange = ExchangeWallet::where('id', $id)->first();
        $this->exchangeId = $exchange->id;
        $this->name = $exchange->name;
        $this->username = $exchange->username;
        $this->available_balance = $exchange->available_balance;
    }

    public function FundAccount($id) {
        $validated = $this->validate([
            'amount' => 'required|numeric|min:100'
        ]);

     
        $exchange = ExchangeWallet::where('id', $id)->where('username', $this->username)->first();
        if(!$exchange) {
            $this->dispatch('alert', type: 'error', text: 'Invalid Route.', position: 'center', timer: 10000, button: false);
            return;
        }
        $admin =  Auth::guard('admin')->user();
        $adminID = $admin->last_name;
        $first_name = $admin->first_name;
        $last_name = $admin->last_name;
        $unit = $validated['amount'] / $exchange->rate;
        $units = (int) ($validated['amount'] / $exchange->rate);
        $exchange->available_balance += $validated['amount'];
        $exchange->total_balance += $validated['amount'];
        $exchange->available_unit += $units;
        $exchange->total_unit += $unit;
        $exchange->description = "{$validated['amount']} was funded into this account by {$first_name} {$last_name} (User ID: {$id})";
        $exchange->save();
        $this->reset('amount');
        $this->fundModel = false;
    }
}
