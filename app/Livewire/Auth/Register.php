<?php

namespace App\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Status;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NovajiNotification;

class Register extends Component
{

    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;


    #[Validate('required|email|unique:users')]
    public $email;


    #[Validate('required|numeric|digits_between:11,16|unique:users')]
    public $mobile;

    #[Validate('required|min:6|max:30|confirmed')]
    public $password;


    #[Validate('required')]
    public $password_confirmation;


    #[Validate('required|unique:users')]
    public $company_name;



    
    #[Title(content: 'Register')]
    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.guest_layout')->section('guest-section');
    }

    public function registerUser() {
        $validated = $this->validate();

        unset($validated['password_confirmation']);
        $validated['password'] = bcrypt($validated['password']);
        $validated['email'] = strtolower($validated['email']);
        $activeStatus = Status::where('name', 'active')->first();
        $userRole = Role::where('name', 'user')->first();

        $validated['username'] = $validated['email'];  
        $validated['status_id'] = $activeStatus->id; 
        $validated['role_id'] = $userRole->id;  
        $user = User::create($validated);

        $this->reset(['first_name', 'last_name', 'email', 'mobile', 'password', 'company_name']);

        Auth::login($user);
        $this->dispatch('alert', type: 'success', text: 'Login Successfully.', position: 'center', timer: 10000, button: false);

        return redirect()->route('dashboard');

    }
}
