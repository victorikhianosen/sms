<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    #[Title('API Documentation')]
    public function render()
    {
        return view('livewire.user.change-password')->extends('layouts.auth_layout')->section('auth-section');
    }

    public function UpdateUserPassword()
    {
        $this->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->dispatch('alert', type: 'error', text: 'The current password is incorrect.', position: 'center', timer: 10000, button: false);

            return;
        }

        if ($this->password !== $this->password_confirmation) {
            session()->flash('error', '.');
            $this->dispatch('alert', type: 'error', text: 'The new password and confirmation do not match.', position: 'center', timer: 10000, button: false);

            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        $this->dispatch('alert', type: 'success', text: 'Password updated successfully!.', position: 'center', timer: 10000, button: false);

    }
}
