<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ApiCredentialService
{

    public function generateApiCredentials(User $user)
    {
        // $apiKey = Str::random(32);
        $apiKey = 'TRIX_' . Str::random(32);

        while (User::where('api_key', $apiKey)->exists()) {
            $apiKey = Str::random(32);
        }
        // $apiSecret = Str::random(32);
        $apiSecret = 'TRIX_SECRET_' . Str::random(32);


        // dd($apiKey, $apiSecret);

        $user->api_key = $apiKey;
        $user->api_secret = $apiSecret;

        $user->save();
    }



    // public function generateApiCredentials(User $user)
    // {
    //     // Generate a unique API key
    //     do {
    //         $apiKey = 'TRIX_' . Str::random(32);
    //     } while (User::where('api_key', $apiKey)->exists());

    //     // Generate a unique API secret
    //     do {
    //         $apiSecret = 'TRIX_SECRET_' . Str::random(32);
    //     } while (User::where('api_secret', $apiSecret)->exists());

    //     // Save credentials to the user
    //     $user->api_key = $apiKey;
    //     $user->api_secret = $apiSecret;
    //     $user->save();
    // }
}
