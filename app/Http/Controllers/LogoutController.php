<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('alert', [
            'type' => 'success',
            'text' => 'Logout Successful!',
            'position' => 'center',
            'timer' => 4000,
            'button' => false,
        ]);
        return redirect()->route('login');
    }

    public function adminLogout(Request $request) {
        Auth::guard('admin')->logout(); 

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('alert', [
            'type' => 'success',
            'text' => 'Logout Successful!',
            'position' => 'center',
            'timer' => 4000,
            'button' => false,
        ]);
        return redirect()->route('admin.login'); 
    }
}


