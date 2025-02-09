<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateVirtualAccountJob implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $validatedData;

    // Constructor to pass the necessary data
    public function __construct(User $user, array $validatedData)
    {
        $this->user = $user;
        $this->validatedData = $validatedData;
    }

    // Handle method to execute the job
    public function handle()
    {
        // Create the virtual account
        $url = rtrim(env('CASHMATRIX_BASE_URL'), '/') . '/virtual-account/create';
        $headers = [
            'Content-Type' => 'application/json',
            'publickey' => env('CASHMATRIX_PUBLIC_KEY'),
            'secretkey' => env('CASHMATRIX_SECRET_KEY')
        ];

        $full_name = $this->validatedData['first_name'] . ' ' . $this->validatedData['last_name'];
        $account_number = substr($this->validatedData['phone'], 1);

        $payload = [
            "accountName" => $full_name,
            "accountNumber" => $account_number,
            "SettlementAccountNumber" => env('SETTLEMENT_ACCOUNT_NUMBER')
        ];

        // Call the external API to create the virtual account
        $response = Http::withHeaders($headers)->post($url, $payload)->json();

        // Check if the account creation was successful
        if ($response['status'] === true && $response['responseCode'] === "00") {
            // Update the user's account number in the database
            $this->user->update(['account_number' => $account_number]);
        }
    }
}
