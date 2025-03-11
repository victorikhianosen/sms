<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;


class LedgerList extends Component
{

    public $search = '';

    public $editModal = false;

    public $fundModal = false;

    public $name;
    public $description;

    public $account_number, $balance;
    public $amount, $ledgerId;



    #[Title('Ledgers')]
    public function render()
    {
        
        $ledgers = GeneralLedger::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('account_number', 'like', '%' . $this->search . '%')
                        ->orWhere('balance', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        // dd($ledgers);

        return view('livewire.admin.ledger-list', [
            'ledgers' => $ledgers
        ])->extends('layouts.admin_layout')->section('admin-section');
    }

    public function closeModal()
    {
        $this->editModal = false;
        $this->fundModal = false;
    }

    public function addModal()
    {
        $this->editModal = true;
    }

    public function AddLedgers()
    {
        $validated = $this->validate([
            'name' => 'required|min:4|max:30|unique:general_ledgers',
            'description' => 'nullable|min:3|max:30',
        ]);

        $accountCode = '9' . Str::padLeft(rand(0, 9999999), 7, '0');

        if (GeneralLedger::where('account_code', $accountCode)->exists()) {
            $accountCode = '9' . Str::padLeft(rand(0, 9999999), 7, '0');
        }

        $validated['account_code'] = $accountCode;
        GeneralLedger::create($validated);
        $this->dispatch('alert', type: 'success', text: 'Ledger Added successfully.', position: 'center', timer: 10000, button: false);

        $this->editModal = false;
    }

    public function addFundModal($id)
    {
        $this->fundModal = true;
        $this->ledgerId = $id;
        $ledgers = GeneralLedger::where('id', $id)->first();
        $this->name = $ledgers->name;
        $this->account_number = $ledgers['account_number'];
        $this->balance = $ledgers['balance'];
    }

    public function FundLedger()
    {

        $validated = $this->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $ledger = GeneralLedger::where('id', $this->ledgerId)->first();

        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Error in fetching Ledger.', position: 'center', timer: 5000);
            return;
        }

        $admin = Auth::guard('admin')->user();

        $previousBalance = $ledger->balance;

        $ledger->balance += $validated['amount'];
        $ledger->save();

        $reference = $this->generateReference($admin);
        $admin->transactions()->create([
            'general_ledger_id' => $ledger->id,
            'amount' => $validated['amount'],
            'transaction_type' => 'credit',
            'balance_before' => $previousBalance,
            'balance_after' => $ledger->balance,
            'reference' => $reference,
            'description' => "Manual $reference",
            'status' => 'success',
            'method' => 'manual'
        ]);

        $this->reset();
        $this->fundModal = false;
        $this->dispatch('alert', type: 'success', text: 'Funds added successfully.', position: 'center', timer: 5000);
    }


    private function generateReference($admin)
    {
        $adminID = $admin['id'];
        $firstTwoFirstName = strtoupper(substr($admin->first_name, 0, 2));
        $firstTwoLastName = strtoupper(substr($admin->last_name, 0, 2));
        $firstThreeDigits = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
        $fourLetters = strtoupper(Str::random(4));
        $sevenDigitNumber = random_int(100000, 999999);
        $lastThreeLetters = ucfirst(Str::random(2)) . 'C';

        return "{$firstThreeDigits}{$fourLetters}{$sevenDigitNumber}{$lastThreeLetters}{$adminID}{$firstTwoFirstName}{$firstTwoLastName}/MAN";
    }

}
