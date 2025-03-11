<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Credit;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\BankTransfer;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PaymentController extends Controller
{
    use HttpResponses;

    public function verifyPayment($reference)
    {
        $response = $this->verifyTransaction($reference);

        if($response['status'] === true && $response['message'] === 'Verification successful' && $response['data']['status'] === 'success'){

            $result = $response['data'];
            $user = Auth::user();

            $amount = $result['amount'] / 100;
            $user->balance += $amount;
            $user->last_payment_reference = $result['reference'];
            $user->save();

            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $result['amount'] / 100, // Convert amount to the correct unit
                'status' => $result['status'],
                'transaction_number' => $result['id'],
                'reference' => $result['reference'],
                'bank_name' => $result['authorization']['bank'] ?? null,
                'account_number' => $result['authorization']['receiver_bank_account_number'] ?? null,
                'card_last_four' => $result['authorization']['last4'] ?? null,
                'card_brand' => $result['authorization']['brand'] ?? null,
                'currency' => $result['currency'],
                'payment_type' => 'credit',
                'payment_method' => $result['authorization']['channel'] ?? null,
                'paystack_response' => json_encode($response),
                'verify_response' => json_encode($response),
                'description' => "Credit updated for Paystack transaction reference " . $result['reference'],
            ]);

            $balanceBeforeUser = $user->balance;
            $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
            if (!$ledger) {   

                session()->flash('alert', [
                'type' => 'error',
                'text' => 'Error in fetching Ledger.!',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);
                
                return;
            }

            $balanceBeforeGL = $ledger->balance;

            $ledger->balance += $amount;
            $ledger->save();

            Transaction::create([
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'general_ledger_id' => $ledger->id,
                'amount' => $amount,
                'transaction_type' => 'debit',
                'balance_before' => $balanceBeforeUser,
                'balance_after' => $user->balance,
                'method' => $result['authorization']['channel'] ?? null,
                'reference' => $result['reference'],
                'description' => "Funds added by admin (₦" . number_format($amount, 2) . ") . " . $result['reference'],
                'status' => 'success',
            ]);

            session()->flash('alert', [
                'type' => 'success',
                'text' => 'Payment Successful!',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);

            return redirect()->route('dashboard');
        }
        else {
            dd('Victor');
        }
    }

    
    private function verifyTransaction($reference)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$secretKey}",
            'Accept' => 'application/json',
        ])->get("https://api.paystack.co/transaction/verify/{$reference}")->json();
        return $response;
    }


    public function matrixCallback(Request $request)
    {
        LogService::payment("CashMatrix received:', " . json_encode($request->all()));
        $accountNumber = $request->accountNumber;
        $amount = (float) $request->amount;
        $user = User::where('account_number', $accountNumber)->first();
        if (!$user) {
            LogService::payment("Account number {$accountNumber} not found.");
            return;
        }
        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            LogService::payment("Error fetching Ledger for account number {$accountNumber}.");
            return;
        }

        $balanceBeforeUser = $user->account_balance;
        $balanceBeforeGL = $ledger->balance;
        $user->account_balance += $amount;
        $user->save();

        $ledger->balance += $amount;
        $ledger->save();

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'success',
            'transaction_id' => $request->sessionId,
            'reference' => $request->narration,
            'bank_name' => $request->sourceAccountName,
            'account_number' => $request->sourceAccountNumber,
            'currency' => 'naira',
            'payment_type' => 'bank_transfer',
            'description' => "Bank transfer received from {$request->sourceAccountName}",
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'payment_id' => $payment->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $amount,
            'transaction_type' => 'credit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $user->account_balance,
            'method' => 'bank_transfer',
            'reference' => $request->narration,
            'description' => "Bank transfer received (₦" . number_format($amount, 2) . ") from {$request->sourceAccountName}",
            'status' => 'success',
        ]);

        LogService::payment("Payment and transaction successfully recorded for {$accountNumber}");

        return response()->json(['message' => 'Callback processed successfully']);
    }
}
