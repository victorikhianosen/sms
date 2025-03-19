<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class EmailVerification extends Component
{
    public $email;
    public $otp;
    public function mount($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;

        $this->verifyEmail();
    }
    public function render()
    {
        return view('livewire.user.auth.email-verification');
    }
    public function verifyEmail()
    {
        $user = User::where('email', $this->email)->where('otp', $this->otp)->first();
        if (!$user) {
            $this->dispatch('alert', type: 'success', text: 'Invalid credentials.', position: 'center', timer: 10000, button: false);
            return $this->redirectRoute('login');
        }

        if ($user->otp !== $this->otp) {
            $this->dispatch('alert', type: 'error', text: 'Invalid OTP.', position: 'center', timer: 10000, button: false);
            return $this->redirectRoute('login');
        }

        if (Carbon::parse($user->otp_expired_at)->lt(now())) {
            $this->dispatch('alert', type: 'error', text: 'OTP has expired..', position: 'center', timer: 10000, button: false);
            return $this->redirectRoute('login');
        }
        
        $user->update([
            'email_verified_at' => now(),
            'otp' => null,
            'otp_expired_at' => null,
            'status' => 'active',
        ]);
        
        $this->dispatch('alert', type: 'success', text: 'Email verified successfully. Kindly login', position: 'center', timer: 10000, button: false);
        return redirect()->route('login');
    }
}
