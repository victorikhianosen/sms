<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Mail\AdminCreatedMail;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
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



    #[Title('User Details')]


    public function render()
    {
        $admins = Admin::latest()->paginate(10);
        return view('livewire.admin.admin-list', [
            'allAdmins' => $admins
        ])->extends('layouts.admin_layout')->section('admin-section');
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


    public function deleteAdmin($id) {
        // dd($id);
        $admin = Admin::find($id);
        $admin->delete();
        $this->dispatch('alert', type:'success', text: 'Admin Account deleted successfully.', position: 'center', timer: 10000, button: false);
    }
}
