<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Mail\ForgetPasswordMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use App\Notifications\GgtSmsNotification;

class ForgetPassword extends Component
{

    #[Validate('required|email')]
    public $email;

    #[Title('Forget Password')]
    public function render()
    {
        return view('livewire.user.auth.forget-password')->extends('layouts.guest_layout')->section('guest-section');
    }


    public function UserForgetPassword()
    {
        $validated = $this->validate();
        $user = User::Where('email', $validated['email'])->first();

        if (!$user) {
            $this->addError('email', 'Invalid Credentials');
            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }

        $otp = random_int(100000, 999999);
        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(10);
        $user->save();

        $firstName = $user->first_name;


        // $userData = [
        //     'body' => 'Welcome to our platform! Your one-time password (OTP) for logging in is:',
        //     'text' => $otp,
        //     'footer' => 'This OTP will expire in 10 minutes. If you did not request this, please contact support.'
        // ];

        Mail::to($validated['email'])->send(new ForgetPasswordMail($firstName, $otp));

        // $user->notify(new GgtSmsNotification($userData));
        $this->dispatch('alert', type: 'success', text: 'OTP sent to your email.', position: 'center', timer: 10000, button: false);

        // return $this->redirectRoute(name: 'resetpassword', navigate: true, ['email' => $validated['email']]);
        return $this->redirectRoute('verifytoken', ['email' => $validated['email']], navigate: true);
    }
}
