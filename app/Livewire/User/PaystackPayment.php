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
        // Remove any non-numeric characters (like commas) before calculating
        $numericValue = preg_replace('/[^\d.]/', '', $value);

        // Format the amount with commas and two decimal places
        $this->formattedAmount = $numericValue !== '' ? number_format((float)$numericValue, 2) : '';

        // Calculate the units and format it
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
        // Validate the amount
        $this->validate();

        // Ensure the email is not empty and the user is authenticated
        $user = Auth::user(); // Fallback if not authenticated

        // dd($email);
        // Prepare the Paystack payment data
        $amountInKobo = $this->amount * 100; // Convert to kobo (Paystack's requirement)

        // $this->dispatch('paystackPayment', [
        //     'email' => $email,
        //     'amount' => $amountInKobo,
        //     'currency' => 'NGN',
        // ]);

        $this->dispatch('paystackPayment', [
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'amount' => $amountInKobo,
            'currency' => 'NGN',
        ]);
    }



}


