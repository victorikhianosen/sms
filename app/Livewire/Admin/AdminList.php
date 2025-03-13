<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\GeneralLedger;
use Livewire\WithFileUploads;
use App\Mail\AdminCreatedMail;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\GgtSmsNotification;

class AdminList extends Component
{

    use WithFileUploads;
    use WithFileUploads;

    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;

    #[Validate('required|min:11|unique:admins')]
    public $phone_number;

    #[Validate('required|email|unique:admins')]
    public $email;

    #[Validate('required')]
    public $role;
    // #[Validate('required')]
    // public $stat/us;
    #[Validate('required|min:6|max:20')]
    public $password;

    public $allRoles = [
        'admin' => 'Admin',
        'super_admin' => 'Super Admin',
        'supervisor' => 'Supervisor',
    ];

    public $editFundModel = false;

    public $admin_email, $admin_phone, $admin_available_balance, $adminID, $amount;


    protected $referenceService;

    public function __construct()
    {
        $this->referenceService = app(ReferenceService::class);
    }
    #[Title('User Details')]
    public function render()
    {
        $admins = Admin::latest()->paginate(10);
        return view('livewire.admin.admin-list', [
            'allAdmins' => $admins
        ])->extends('layouts.admin_layout')->section('admin-section');
    }


    public function closeModal()
    {
        $this->editFundModel = false;
    }


    public function AddNewAdmin()
    {

        $validated = $this->validate();

        $admin = Admin::create($validated);

        $data = [
            'body'   => "Dear {$validated['first_name']},\n\nYour admin account has been successfully created.",
            'text'   => "Login Credentials:\nEmail: {$validated['email']}\nPassword: {$validated['password']}",
            'footer' => "For security reasons, please change your password after logging in.\nIf you have any questions, contact support.",
        ];

        $data = array_map('nl2br', $data);

        Mail::to($validated['email'])->send(new AdminCreatedMail(
            $validated['first_name'],
            $validated['email'],
            $validated['password']
        ));
        // $admin->notify(new GgtSmsNotification($data));


        $this->reset();

        $this->dispatch('alert', type: 'success', text: 'Admin created successfully.', position: 'center', timer: 10000, button: false);
    }


    public function deleteAdmin($id)
    {
        // dd($id);
        $admin = Admin::find($id);
        $admin->delete();
        $this->dispatch('alert', type: 'success', text: 'Admin Account deleted successfully.', position: 'center', timer: 10000, button: false);
    }

    public function showAddFunds($id)
    {
        $this->editFundModel = true;
        $this->adminID = $id;
        $admin = Admin::find($id);
        $this->admin_email = $admin->email;
        $this->admin_phone = $admin->phone_number;
        $this->admin_available_balance = $admin->balance;
    }

    public function addAdminFunds()
    {

        $validated = $this->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        // Find the user by ID
        $admin = Admin::find($this->adminID);
        // dd($user);

        if (!$admin) {
            $this->dispatch(event: 'alert', type: 'error', text: 'User not found.', position: 'center', timer: 5000, button: false);
            return;
        }

        $Authadmin = Auth::guard('admin')->user();

        $reference = $this->referenceService->referenceWithDetails($Authadmin);
        $transaction_number = $this->referenceService->generateReference($Authadmin);

        // dd($reference, $transaction_number);


        $ledger = GeneralLedger::where('id', 1)->where('account_number', '99248466')->first();
        // dd($ledger );
        if (!$ledger) {
            $this->dispatch('alert', type: 'error', text: 'Error in fetching Ledger.', position: 'center', timer: 5000);
            return;
        }

        $balanceBeforeGL = $ledger->balance;

        $admin->balance += $this->amount;
        $ledger->balance += $this->amount;

        $admin->save();
        $ledger->save();

        $payment = Payment::create([
            'admin_id' => $admin->id,
            'amount' => $this->amount,
            'status' => 'success',
            'transaction_number' => $transaction_number,
            'reference' => $reference,
            'currency' => 'NGN',
            'payment_type' => 'credit',
            'payment_method' => 'manual',
            'description' => "Manual fund addition by admin of ₦" . $reference  . number_format($this->amount, 2),
        ]);

        Transaction::create([
            'admin_id' => $admin->id,
            'payment_id' => $payment->id,
            'general_ledger_id' => $ledger->id,
            'amount' => $this->amount,
            'transaction_type' => 'debit',
            'balance_before' => $balanceBeforeGL,
            'balance_after' => $ledger->balance,
            'payment_method' => 'manual',
            'reference' => $payment->reference,
            'description' => "Funds added by admin (₦" . number_format($this->amount, 2) . ")",
            'status' => 'success',
        ]);

        $this->reset('amount');
        $this->editFundModel = false;
        $this->dispatch('alert', type: 'success', text: 'Funds added successfully.', position: 'center', timer: 5000, button: false);
    }
}
