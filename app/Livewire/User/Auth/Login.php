<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{


    #[Validate('required|email')]
    public $email;


    #[Validate('required')]
    public $password;
    #[Title('Login')]
    public function render()
    {
        return view('livewire.user.auth.login')->extends('layouts.guest_layout')->section('guest-section');
    }

    public function loginUser()
    {
        Auth::logout();
        Auth::guard('admin')->logout(); 
        $validated = $this->validate();

        // dd($validated['email']);
        $user = User::Where('email', $validated['email'])->first();


        if ($user['status'] !== 'active') {
            $this->addError('email', 'Your account has been deactivated');
            $this->dispatch('alert', type: 'error', text: 'Your account has been deactivated.', position: 'center', timer: 10000, button: false);
            return;
        }


        
        if(!$user) {
            $this->addError('email', 'Invalid email');
            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }

        // Attempt to log the user in
        if (!Auth::attempt($validated)) {
            $this->addError('email', 'Incorrect Login Details');
            $this->dispatch('alert', type: 'error', text: 'Incorrect Login Details', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->dispatch('alert', type: 'success', text: 'Login Successful!', position: 'center', timer: 10000, button: false);

        // Redirect to the dashboard or another page
        return redirect()->route('dashboard');
    }
}
