<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Mail\AdminCreatedMail;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
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

        // Update the user's balance
        $admin->balance += $this->amount;
        $admin->save();



        $AuthAdmin = Auth::guard('admin')->user();

        $AuthAdmin_id = $AuthAdmin->id;
        $AuthAdminFirstname = $AuthAdmin->first_name;
        $AuthAdminLastname = $AuthAdmin->last_name;

        // Get first letters of first and last name
        $initials = strtoupper(substr($AuthAdminFirstname, 0, 2) . substr($AuthAdminLastname, 0, 2));

        // Generate the reference
        $reference =  $AuthAdmin_id . $initials . '_' . strtoupper(Str::random(10));

        $payment = Payment::create([
            'admin_id' => $admin->id,
            'amount' => $this->amount,
            'status' => 'success',
            'transaction_number' => Str::uuid(),
            'reference' => $reference,
            'bank_name' => null,
            'account_number' => null,
            'card_last_four' => null,
            'card_brand' => null,
            'currency' => 'NGN',
            'payment_type' => 'manual',
            'paystack_response' => null,
            'verify_response' => null,
            'description' => "Manual fund addition by admin of ₦" . $reference  . number_format($this->amount, 2),
        ]);


        // Reset input fields
        $this->reset('amount');

        $this->editFundModel = false;

        // Show success message
        $this->dispatch('alert', type: 'success', text: 'Funds added successfully.', position: 'center', timer: 5000, button: false);
    }
}
