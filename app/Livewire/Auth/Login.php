<?php

namespace App\Livewire\Auth;

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
        return view('livewire.auth.login')->extends('layouts.guest_layout')->section('guest-section');
    }

    // public function loginUser()
    // {
    //     $validated = $this->validate();
    //     $user = User::where('email', $validated['email']);
    //     if (!$user) {
    //         $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
    //         return;
    //     }


    // }


    public function loginUser()
    {
        // Validate the incoming request data
        $validated = $this->validate();

        // Attempt to log the user in
        if (!Auth::attempt($validated)) {

            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }

        $this->dispatch('alert', type: 'success', text: 'Login Successful!', position: 'center', timer: 10000, button: false);

        // Redirect to the dashboard or another page
        return redirect()->route('dashboard');
    }
}
