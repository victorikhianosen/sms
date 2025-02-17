<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Component
{


    #[Validate('required|required')]
    public $email;

    #[Validate('required')]
    public $password;
    #[Title('Admin Login')]
    public function render()
    {
        return view('livewire.admin.auth.admin-login')->extends('layouts.guest_layout')->section('guest-section');
    }
    
    public function Login()
    {
        $validated = $this->validate();

        // Find the admin by email
        $admin = Admin::where('email', $validated['email'])->first(); // Fixed where clause

        // Validate password
        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            $this->dispatch('alert', type: 'error', text: 'Invalid login credentials.', position: 'center', timer: 10000, button: false);
            return;
        }
        if ($admin->status !== 'active') {
            $this->dispatch('alert', type: 'error', text: 'Your account has not been activated. Please contact the administrator.', position: 'center', timer: 10000, button: false);
            return;
        }

        // Attempt authentication
        Auth::guard('admin')->attempt(['email' => $validated['email'], 'password' => $validated['password']]);

        // Show success message
        $this->dispatch('alert', type: 'success', text: 'Login Successfully.', position: 'center', timer: 10000, button: false);

        return redirect()->route('admin.dashboard');
        // Redirect to dashboard
        // return $this->redirectRoute('admin.dashboard', navigate: true);
    }

}
