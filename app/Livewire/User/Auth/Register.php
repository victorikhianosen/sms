<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Correct namespace for the User model

class Register extends Component
{



    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;

    #[Validate('required|numeric|digits:11|unique:users')]
    public $phone;


    #[Validate('required|email|unique:users')]
    public $email;

    #[Validate('required|min:6|max:30|confirmed')]
    public $password;

    #[Validate('required')]
    public $password_confirmation;



    #[Title('Register')]
    public function render()
    {
        return view('livewire.user.auth.register')->extends('layouts.guest_layout')->section('guest-section');
    }



    public function registerUser()
    {
        $validated = $this->validate();
        unset($validated['password_confirmation']);
        $user = User::create($validated);
        $this->generateApiCredentials($user);
        $this->reset();
        // dd($this->createVirtualAccount());
        Auth::login($user);


        $this->dispatch('alert', type: 'success', text: 'Registration successfully.', position: 'center', timer: 10000, button: false);
        return redirect()->route('dashboard');
    }

    private function generateApiCredentials(User $user)
    {
        $apiKey = Str::random(length: 32);
        while (User::where('api_key', $apiKey)->exists()) {
            $apiKey = Str::random(32);
        }
        $apiSecret = Str::random(32);
        $user->api_key = $apiKey;
        $user->api_secret = $apiSecret;
        $user->save();
    }


    public function createVirtualAccount()
    {
        $url = rtrim(env('CASHMATRIX_BASE_URL'), '/') . '/virtual-account/create'; // Ensure proper URL format

        // dd($url);
        $headers = [
            'Content-Type' => 'application/json',
            'public_key' => env('CASHMATRIX_PUBLIC_KEY'),
            'secret_key' => env('CASHMATRIX_SECRET_KEY')
        ];

        $payload = [
            "accountName" => "$this->first_name $this->last_name",
            "accountNumber" => substr($this->phone, 1),
            "SettlementAccountNumber" => env('SETTLEMENT_ACCOUNT_NUMBER')
        ];

        $response = Http::withHeaders($headers)->post($url, $payload);

        dd($response);
    }




    // public function registerUser(){

    //     $validated = $this->validate();

    //     $validated['username'] = $validated['email'];

    //     unset($validated['password_confirmation']);

    //     $user = User::create($validated);

    //     $this->reset();

    //     Auth::login($user);
    //     $this->dispatch('alert', type: 'success', text: 'Registration successfully.', position: 'center', timer: 10000, button: false);

    //     return redirect()->route('dashboard');
    // }
}
