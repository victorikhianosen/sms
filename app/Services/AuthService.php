<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Notifications\UserRegisteredNotification;

class AuthService
{
    
    public function registerUser($validated)
    {
       return $validated;
    }



}
