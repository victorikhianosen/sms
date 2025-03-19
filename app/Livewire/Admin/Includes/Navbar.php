<?php

namespace App\Livewire\Admin\Includes;

use App\Models\User;
use App\Models\Admin;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\GeneralLedger;
use App\Models\ExchangeWallet;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{

    public $allUserBalance;

    public $allAdminBalance;

    public $ledgerBalance;

    public $totalBalance;

    public $exchangeTransBalance;
    public $exchangeProBalance;

    public $exchangeTransUnit;
    public $exchangeProUnit;







    public $balance;
    public $first_name;

    public function render()
    {

        return view('livewire.admin.includes.navbar');
    }

    public function getAllUserBalance() {
        $this->allUserBalance = User::sum(column: 'balance');
        $this->allAdminBalance = Admin::sum(column: 'balance');
        $this->ledgerBalance = GeneralLedger::sum('balance');
        $this->totalBalance = $this->allUserBalance + $this->allAdminBalance;
        $exchangeTrans = ExchangeWallet::where('username', 'ggttxmt')->first();
        $exchangePro = ExchangeWallet::where('username', 'ggtprmt')->first();
        $this->exchangeTransUnit = $exchangeTrans->available_unit;
        $this->exchangeProUnit = $exchangePro->available_unit;
        
        $this->exchangeTransBalance = $exchangeTrans->available_balance;
        $this->exchangeProBalance = $exchangePro->available_balance;

        
        $admins = Auth::guard('admin')->user();
        $this->first_name = $admins->first_name;
        $this->balance = $admins->balance;
    }

}
