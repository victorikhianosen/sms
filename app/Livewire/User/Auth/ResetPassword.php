<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Component
{

    #[Validate('required|email')]
    public $email;


    #[Validate('required|min:6|max:30|confirmed')]
    public $password;

    #[Validate('required|min:6|max:30')]
    public $password_confirmation;

    #[Title('Reset Password')]
    public function render()
    {
        return view('livewire.user.auth.reset-password')->extends('layouts.guest_layout')->section('guest-section');
    }



    public function resetUserPassword()
    {
        $validated = $this->validate();

        // Find the user based on the validated email
        $user = User::where('email', $validated['email'])->first();

        // Check if the user exists
        if (!$user) {
            $this->addError('email', 'Invalid Credentials');
            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }

        // Hash the password and update the user's password
        $validated['password'] = bcrypt($validated['password']);

        $user->password = $validated['password'];
        $user->update();

        // Reset the form and dispatch a success message
        $this->reset();
        $this->dispatch('alert', type: 'success', text: 'Password Reset Successfully.', position: 'center', timer: 10000, button: false);

        // Redirect to login route
        return redirect()->route('login');
    }
}
