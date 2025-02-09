<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankTransfer;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;


class CallBackController extends Controller
{

    use HttpResponses;
    public function callback(Request $request)
    {
        Log::info('Callback received:', $request->all());
        return $this->success( $request->all(), 'Callback successfully');
    }

     public function matrixCallback(Request $request){


        Log::info('CashMatrix received:', $request->all());

        $accountNumber = $request->accountNumber;
        $amount = (float) $request->amount;

        $user = User::where('account_number', $accountNumber)->first();

        if ($user) {
            $user->update([
                'account_balance' => $user->account_balance + $amount
            ]);

            BankTransfer::create([
                'account_name' => $request->accountName,
                'account_number' => $accountNumber,
                'amount' => $amount,
                'tranx_fee' => $request->tranxfee,
                'narration' => $request->narration,
                'session_id' => $request->sessionId,
                'source_account_number' => $request->sourceAccountNumber,
                'source_account_name' => $request->sourceAccountName,
            ]);

            Log::info("Account balance updated for {$accountNumber}");
        } else {
            Log::info("Account number {$accountNumber} not found.");
        }

        Log::info("MatrixPay CallBack: {$request->all()}");

        // return response()->json(data: ['message' => 'Callback processed'], 200);

    }
}
