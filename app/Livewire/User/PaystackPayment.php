<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class PaystackPayment extends Component
{



    #[Validate('required|numeric')]
    public $amount;


    public $formattedAmount = '';
    public $units = '';
    public $formattedUnits = ''; // Formatted units

    public function updatedAmount($value)
    {
        $numericValue = preg_replace('/[^\d.]/', '', $value);
        $this->formattedAmount = $numericValue !== '' ? number_format((float)$numericValue, 2) : '';
        $this->units = $numericValue !== '' ? round($numericValue / 3.5, 2) : 0;
        $this->formattedUnits = $this->units !== '' ? number_format((float)$this->units, 2) : '';
    }


    #[Title('Paystack Payment')]
    public function render()
    {
        return view('livewire.user.paystack-payment')->extends('layouts.auth_layout')->section('auth-section');
    }



    public function makePayment()
    {
        $this->validate();
        $user = Auth::user();

        // Ensure first name and last name are not empty
        if (empty($user->first_name) || empty($user->last_name)) {
            $this->dispatch('alert', [
                'type' => 'error',
                'text' => 'Please update your profile with your full name before making a payment.',
                'position' => 'center',
                'timer' => 5000
            ]);
            return;
        }

        $amountInKobo = $this->amount * 100;


        $this->dispatch('paystackPayment', [
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'amount' => $amountInKobo,
            'currency' => 'NGN',
            'metadata' => [
                'customer_details' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'amount' => $amountInKobo,
                ]
            ]
        ]);
    }
}
