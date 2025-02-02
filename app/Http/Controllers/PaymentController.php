<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function verifyPayment($reference)
    {
        $response = $this->verifyTransaction($reference);

        if ($response) {
            return redirect()->route('dashboard')
                ->with('success', 'Payment successfully verified.');
        } else {
            return redirect()->back()
                ->with('error', 'Transaction verification failed. Please try again.');
        }
    }




    private function verifyTransaction($reference)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$secretKey}",
            'Accept' => 'application/json',
        ])->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->failed()) {
            session()->flash('alert', [
                'type' => 'error',
                'text' => 'Unable to verify payment at the moment!',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);
            return redirect()->route('payment.paystack');
        }

        $response = $response->json();

        if ($response['status'] && $response['data']['status'] === 'success') {
            $result = $response['data'];
            $user = Auth::user();

            // Save payment details to the Payment table (for successful payment)
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $result['amount'] / 100, // Convert amount to the correct unit
                'status' => $result['status'],
                'transaction_id' => $result['id'],
                'reference' => $result['reference'],
                'bank_name' => $result['authorization']['bank'] ?? null,
                'account_number' => $result['authorization']['receiver_bank_account_number'] ?? null,
                'card_last_four' => $result['authorization']['last4'] ?? null,
                'card_brand' => $result['authorization']['brand'] ?? null,
                'currency' => $result['currency'],
                'payment_type' => 'card',
                'paystack_response' => json_encode($response),
                'verify_response' => json_encode($response),
                'description' => "Credit updated for Paystack transaction reference " . $result['reference'],
            ]);

            $user->balance = ($user->balance ?? 0) + ($result['amount'] / 100);
            $user->last_payment_reference = $result['reference'];
            $user->save();

            session()->flash('alert', [
                'type' => 'success',
                'text' => 'Payment Successful!',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);

            return redirect()->route('dashboard');
        } else {
            // Save payment details to the Payment table (for failed payment)
            $failedPayment = Payment::create([
                'user_id' => Auth::id(),
                'amount' => 0, // For failed payment, we set amount as 0 or any other default value
                'status' => 'failed',
                'transaction_id' => $response['data']['id'] ?? null,
                'reference' => $response['data']['reference'] ?? null,
                'bank_name' => $response['data']['authorization']['bank'] ?? null,
                'account_number' => $response['data']['authorization']['receiver_bank_account_number'] ?? null,
                'card_last_four' => $response['data']['authorization']['last4'] ?? null,
                'card_brand' => $response['data']['authorization']['brand'] ?? null,
                'currency' => $response['data']['currency'] ?? null,
                'payment_type' => 'card',
                'paystack_response' => json_encode($response),
                'verify_response' => json_encode($response),
                'description' => "Payment failed for Paystack transaction reference " . ($response['data']['reference'] ?? 'N/A'),
            ]);

            session()->flash('alert', [
                'type' => 'error',
                'text' => 'Payment verification failed!',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);

            return redirect()->route('payment.paystack');
        }
    }



    // private function verifyTransaction($reference)
    // {
    //     $secretKey = env('PAYSTACK_SECRET_KEY');

    //     $response = Http::withHeaders([
    //         'Authorization' => "Bearer {$secretKey}",
    //         'Accept' => 'application/json',
    //     ])->get("https://api.paystack.co/transaction/verify/{$reference}");

    //     if ($response->failed()) {
    //         session()->flash('alert', [
    //             'type' => 'error',
    //             'text' => 'Unable to verify payment at the moment!',
    //             'position' => 'center',
    //             'timer' => 4000,
    //             'button' => false,
    //         ]);
    //         return redirect()->route('payment.paystack');
    //     }

    //     $response = $response->json();

    //     if ($response['status'] && $response['data']['status'] === 'success') {
    //         $result = $response['data'];
    //         $user = Auth::user();

    //         // Save payment details to the Payment table
    //         $payment = Payment::create([
    //             'user_id' => $user->id,
    //             'amount' => $result['amount'] / 100, // Convert amount to the correct unit
    //             'status' => $result['status'],
    //             'transaction_id' => $result['id'],
    //             'reference' => $result['reference'],
    //             'bank_name' => $result['authorization']['bank'] ?? null,
    //             'account_number' => $result['authorization']['receiver_bank_account_number'] ?? null,
    //             'card_last_four' => $result['authorization']['last4'],
    //             'card_brand' => $result['authorization']['brand'],
    //             'currency' => $result['currency'],
    //             'payment_type' => 'card',
    //             'paystack_response' => json_encode($response),
    //             'verify_response' => json_encode($response),
    //             'description' => "Credit updated for Paystack transaction reference " . $result['reference'],
    //         ]);

    //         $user->balance = ($user->balance ?? 0) + ($result['amount'] / 100);
    //         $user->last_payment_reference = $result['reference'];
    //         $user->save();

    //         session()->flash('alert', [
    //             'type' => 'success',
    //             'text' => 'Payment Successful!',
    //             'position' => 'center',
    //             'timer' => 4000,
    //             'button' => false,
    //         ]);

    //         return redirect()->route('dashboard');
    //     } else {
    //         session()->flash('alert', [
    //             'type' => 'error',
    //             'text' => 'Payment verification failed!',
    //             'position' => 'center',
    //             'timer' => 4000,
    //             'button' => false,
    //         ]);
    //         return redirect()->route('payment.paystack');
    //     }
    // }


}
