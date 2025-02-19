<?php

namespace App\Livewire\Admin\Includes;

use App\Models\User;
use App\Models\Admin;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{

    public $allUserBalance;

    public $balance;
    public $first_name;

    public function render()
    {
        return view('livewire.admin.includes.navbar');
    }

    public function getAllUserBalance() {
        $this->allUserBalance = User::sum('balance');
        $admins = Auth::guard('admin')->user();
        $this->first_name = $admins->first_name;

        $this->balance = $admins->balance;

        // dd($admins);
    }

}
