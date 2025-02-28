<?php


namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
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

        // dd($user);
        $this->editFundModel = true;
    }



    public function addUserFund()
    {
        // Validate the input
        $validated = $this->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        // Find the user by ID
        $user = User::find($this->userID);
        // dd($user);

        if (!$user) {
            $this->dispatch('alert', type: 'error', text: 'User not found.', position: 'center', timer: 5000, button: false);
            return;
        }

        // Update the user's balance
        $user->balance += $this->amount;
        $user->save();

        $admin = Auth::guard('admin')->user();
        $admin_id = $admin->id;
        $adminFirstname = $admin->first_name;
        $adminLastname = $admin->last_name;

        // Get first letters of first and last name
        $initials = strtoupper(substr($adminFirstname, 0, 2) . substr($adminLastname, 0, 2));

        // Generate the reference
        $reference =  $admin_id . $initials . '_' . strtoupper(Str::random(10));

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $this->amount,
            'status' => 'success',
            'transaction_id' => Str::uuid(),
            'reference' => $reference,
            'bank_name' => null, 
            'account_number' => null,
            'card_last_four' => null,
            'card_brand' => null,
            'currency' => 'NGN',
            'payment_type' => 'manual',
            'paystack_response' => null, 
            'verify_response' => null,
            'description' => "Manual fund addition by admin of ₦". $reference  . number_format($this->amount, 2),
        ]);


        // Reset input fields
        $this->reset('amount', 'available_balance');

        // Close the modal
        $this->editFundModel = false;

        // Show success message
        $this->dispatch('alert', type: 'success', text: 'Funds added successfully.', position: 'center', timer: 5000, button: false);
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



    public function deleteUser($id)
    {
        $admin = User::find($id);
        $admin->delete();
        $this->dispatch('alert', type: 'success', text: 'User Account deleted successfully.', position: 'center', timer: 10000, button: false);
    }
}
