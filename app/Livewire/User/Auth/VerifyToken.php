<?php


namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordMail;

class VerifyToken extends Component
{
    #[Validate('required|email')]
    public $email;

    #[Validate('required|numeric|digits:6')]
    public $otp; // Changed from $token to $otp to match the input in the view

    public $tokenExpired = false; // Track if the OTP is expired

    #[Title('Verify Token')]
    public function render()
    {
        return view('livewire.user.auth.verify-token')->extends('layouts.guest_layout')->section('guest-section');
    }

    // public function mount()
    // {
    //     $user = User::where('email', $this->email)->first();

    //     if ($user && $user->otp_expired_at && $user->otp_expired_at < now()) {
    //         $this->tokenExpired = true; // Set flag if token has expired
    //     }
    // }

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
        $user->otp_expired_at = now()->addMinutes(10);
        $user->save();

        $firstName = $user->first_name;
        Mail::to($this->email)->send(new ForgetPasswordMail($firstName, $otp));

        $this->dispatch('alert', type: 'success', text: 'OTP resent to your email.', position: 'center', timer: 10000, button: false);
    }

    public function verifyUserToken()
    {
        $validated = $this->validate();

        $user = User::where('email', $validated['email'])->first();

        // Check if the user exists
        if (!$user) {
            $this->addError('email', 'Invalid Credentials');
            $this->dispatch('alert', type: 'error', text: 'Invalid Credentials.', position: 'center', timer: 10000, button: false);
            return;
        }



        // Check if the OTP has expired
        if ($user->otp_expired_at && $user->otp_expired_at < now()) {
            $this->addError('otp', 'OTP has expired.');
            $this->dispatch('alert', type: 'error', text: 'OTP has expired. Please request a new one.', position: 'center', timer: 10000, button: false);
            $this->tokenExpired = true;
            return;
        }

        // Check if the OTP is correct
        if ($user->otp !== $validated['otp']) {
            $this->addError('otp', 'Invalid OTP.');
            $this->dispatch('alert', type: 'error', text: 'Invalid OTP. Please try again.', position: 'center', timer: 10000, button: false);
            return;
        }

        // OTP is valid, proceed with whatever action you need
        return $this->redirectRoute('resetpassword', ['email' => $validated['email']], navigate: true);
    }
}
