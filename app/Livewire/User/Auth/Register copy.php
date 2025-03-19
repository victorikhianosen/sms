<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Jobs\CreateVirtualAccountJob; // Correct namespace for the User model

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
        CreateVirtualAccountJob::dispatch($user, $validated);

        // $this->createVirtualAccount($validated, $user);

        $this->reset();
        Auth::login($user);

        $this->dispatch('alert', type: 'success', text: 'Registration successful.', position: 'center', timer: 10000, button: false);
        return redirect()->route('dashboard');
    }


    private function generateApiCredentials(User $user)
    {
        do {
            $apiKey = 'TRIX_' . Str::random(32);
        } while (User::where('api_key', $apiKey)->exists());

        do {
            $apiSecret = 'TRIX_SECRET_' . Str::random(32);
        } while (User::where('api_secret', $apiSecret)->exists());

        $user->api_key = $apiKey;
        $user->api_secret = $apiSecret;
        $user->save();
    }


    // private function generateApiCredentials(User $user)
    // {
    //     $apiKey = Str::random(length: 32);
    //     while (User::where('api_key', $apiKey)->exists()) {
    //         $apiKey = Str::random(32);
    //     }
    //     $apiSecret = Str::random(32);
    //     $user->api_key = $apiKey;
    //     $user->api_secret = $apiSecret;
    //     $user->save();
    // }


    public function createVirtualAccount($validated, $user)
    {
        $url = rtrim(env('CASHMATRIX_BASE_URL'), '/') . '/virtual-account/create'; // Ensure proper URL format
        $headers = [
            'Content-Type' => 'application/json',
            'publickey' => env('CASHMATRIX_PUBLIC_KEY'),
            'secretkey' => env('CASHMATRIX_SECRET_KEY')
        ];

        // dd($user);

        $fetchUser = User::where('id', $user['id'])->where('email', $user['email'])->first();

        // dd($fetchUser);


        $full_name = $fetchUser['first_name'] . ' ' . $fetchUser['last_name'];

        $account_number = substr($fetchUser, 1);
        $payload = [
            "accountName" => $full_name,
            "accountNumber" => $account_number,
            "SettlementAccountNumber" => env('SETTLEMENT_ACCOUNT_NUMBER')
        ];

        $response = Http::withHeaders($headers)->post($url, $payload)->json();

        // $response['accountNumber'] = $account_number;
        // return $response;

        if($response['status'] === true && $response['responseCode'] === "00") {
            $fetchUser->update(['account_number' => $account_number]);
            // return $account_number;
        } else {
            Log::info("MAtricPay Account creation {$account_number} not found.");
        }
    }


}
