<?php

namespace App\Livewire\Include;

use Livewire\Component;
use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;

class NavBar extends Component
{
    public function render()
    {

        $user = Auth::user();
        $accountBalance = $user['balance'];
        // dd($accountBalance);

        return view('livewire.include.nav-bar',[
            // 'accountBalance' => $accountBalance['balance'],
            'accountBalance' => $accountBalance
        ]);
    }
}
