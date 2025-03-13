<?php


namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CreateVirtualAccountJob;

class UserList extends Component
{
    use WithPagination;

    public $search;

    public $allUsers = [];

    public $editModel = false;

    public $editFundModel = false;





    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;

    #[Validate('required|numeric|digits:11|unique:users')]
    public $phone;


    #[Validate('required|email|unique:users')]
    public $email;

    #[Validate('required|min:6|max:30|confirmed')]
    public $password;

    #[Validate('required')]
    public $password_confirmation;

    public $available_balance;

    public $amount;

    public $userID;


    protected $referenceService;

    public function __construct()
    {
        $this->referenceService = app(ReferenceService::class);
    }

    
    #[Title('All Users')]
    public function render()
    {
        // $users = User::latest()->paginate(10);
        // dd($users);

        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-list', [
            'users' => $users
        ])->extends('layouts.admin_layout')->section('admin-section');
    }

    public function closeModal()
    {
        $this->editModel = false;
        $this->editFundModel = false;
    }
    public function AddUser()
    {
        $this->editModel = true;
    }

    public function AddFunds($id)
    {
        $this->userID = $id;
        $user = User::find($id);
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->available_balance = $user->balance;
        $this->editFundModel = true;
    }


    public function addUserFund()
    {

    $validated = $this->validate(['amount' => ['required', 'numeric', 'min:5', 'regex:/^[1-9][0-9]*$/']]);
        $user = User::find($this->userID);
        if (!$user) {
            $this->dispatch('alert', type: 'error', text: 'User not found.', position: 'center', timer: 5000);
            return;
        }

        $admin = Auth::guard('admin')->user();
        $reference = $this->referenceService->referenceWithDetails(data: $admin);
        $transaction_number = $this->referenceService->generateReference($admin);

        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Error in fetching Ledger.', position: 'center', timer: 5000);
            return;
        }

        $balanceBeforeGL = $ledger->balance;
        $user->balance += $this->amount; 
        $ledger->balance += $this->amount; 

        $user->save();
        $ledger->save();

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $this->amount,
            'status' => 'success',
            'transaction_number' => $transaction_number,
            'reference' => $reference,
            'currency' => 'NGN',
            'payment_type' => 'credit',
            'payment_method' => 'manual',
            'description' => "Manual fund addition by admin of ₦" . number_format($this->amount, 2),
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'admin_id' => $admin->id,
            'payment_id' => $payment->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $this->amount,
            'transaction_type' => 'debit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $user->balance,
            'payment_method' => 'manual',
            'reference' => $reference,
            'description' => "Funds added by admin (₦" . number_format($this->amount, 2) . ")",
            'status' => 'success',
        ]);

        $this->reset('amount', 'available_balance');

        $this->editFundModel = false;

        $this->dispatch('alert', type: 'success', text: 'Funds added successfully.', position: 'center', timer: 5000);
    }


    public function AddNewUser()
    {
        $validated = $this->validate();
        unset($validated['password_confirmation']);
        $user = User::create($validated);
        $this->generateApiCredentials($user);
        CreateVirtualAccountJob::dispatch($user, $validated);
        $this->reset('first_name', 'last_name', 'email', 'phone', 'password', 'password_confirmation');
        $this->dispatch('alert', type: 'success', text: 'User created successfully.', position: 'center', timer: 10000, button: false);
    }


    private function generateApiCredentials(User $user)
    {
        do {
            $apiKey = 'TRIX_' . Str::random(32);
        } while (User::where('api_key', $apiKey)->exists());

        do {
            $apiSecret = 'TRIX_SECRET_' . Str::random(32);
        } while (User::where('api_secret', $apiSecret)->exists());

        $user->api_key = $apiKey;
        $user->api_secret = $apiSecret;
        $user->save();
        $this->editModel = false;
    }


}
