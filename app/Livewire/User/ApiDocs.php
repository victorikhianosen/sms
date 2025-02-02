<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class ApiDocs extends Component
{

    #[Title('API Documentation')]

    public $api_key;
    public $api_secret;

    public function render()
    {
        $user = Auth::user();
        $this->api_key = $user['api_key'];
        $this->api_secret = $user['api_secret'];

        // dd($this->api_key, $this->api_secret);
        return view('livewire.user.api-docs')->extends('layouts.auth_layout')->section('auth-section');
    }


    public function updateApiCredentials() {
       $user = Auth::user();
       $this->generateApiCredentials($user);
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
}
