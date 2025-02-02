<?php

namespace App\Livewire\Include;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavBar extends Component
{
    public $accountBalance;

    public function mount()
    {
        $this->updateBalance();
    }

    public function updateBalance()
    {
        $user = Auth::user();
        $this->accountBalance = $user->balance;
    }

    public function render()
    {
        return view('livewire.include.nav-bar');
    }
}
