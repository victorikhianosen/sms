<?php

namespace App\Livewire\User\Auth;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Mail\RegistrationMail;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmail extends Component
{
    #[Validate('required|email|exists:users,email')]
    public $email;

    #[Validate('required')]
    public $otp;

    public $tokenExpired = false;


    #[Title('Verify Email')]
    public function render()
    {
        return view('livewire.user.auth.verify-email')->extends('layouts.guest_layout')->section('guest-section');
    }

    public function verifyEmail()
    {
        $validated = $this->validate();
        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            $this->addError('otp', 'invalid credentials.');
            $this->dispatch('alert', type: 'error', text: 'invalid credentials.', position: 'center', timer: 10000, button: false);
            return;
        }
        if ($user->otp !== $this->otp) {
            $this->addError('otp', 'Invalid OTP.');
            $this->dispatch('alert', type: 'error', text: 'Invalid OTP.', position: 'center', timer: 10000, button: false);
            return;
        }
        if (Carbon::parse($user->otp_expired_at)->lt(now())) {
            $this->addError('otp', 'OTP has expired..');
            $this->dispatch('alert', type: 'error', text: 'OTP has expired..', position: 'center', timer: 10000, button: false);
            $this->tokenExpired = true;
            return;
        }
        $user->update([
            'email_verified_at' => now(),
            'otp' => null,
            'otp_expired_at' => null,
            'status' => 'active',
        ]);
        Auth::login($user);
        $this->dispatch('alert', type: 'success', text: 'Registration Process completed.', position: 'center', timer: 10000, button: false);
        return $this->redirectRoute('dashboard');
    }

    public function resendToken()
    {

        $this->tokenExpired = false;
        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $this->addError('email', 'Invalid Credentials');
            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }
        $otp = random_int(100000, 999999);
        $user->otp = $otp;
        // $user->otp_expired_at = now()->addMinutes(5);
        $user->otp_expired_at = Carbon::now()->addMinutes(5)->toDateTimeString();
        $user->save();
        $firstName = $user->first_name;
        $verificationLink = url('verify-email/' . $user->email . '/' . $otp);
        $this->dispatch('alert', type: 'success', text: 'OTP resent to your email.', position: 'center', timer: 10000, button: false);
        Mail::to($user->email)->send(new RegistrationMail($firstName, $otp, $verificationLink));
    }
}
