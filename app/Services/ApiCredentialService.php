<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ApiCredentialService
{

    public function generateApiCredentials(User $user)
    {
        $apiKey = 'TRIX_' . Str::random(32);
        while (User::where('api_key', $apiKey)->exists()) {
            $apiKey = Str::random(32);
        }
        $apiSecret = 'TRIX_SECRET_' . Str::random(32);
        $user->api_key = $apiKey;
        $user->api_secret = $apiSecret;
        $user->save();
    }

}
