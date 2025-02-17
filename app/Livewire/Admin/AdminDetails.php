<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

class AdminDetails extends Component
{
    public $adminID;

    public $admin = [];

    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $role;
    public $status;
    public $balance;

    public $roleOptions = ['super_admin', 'admin', 'supervisor'];

    public $statusOptions = ['active', 'inactive'];

    #[Validate('required')]
    public $amount;

    public function mount($id)
    {
        $this->adminID = $id;
    }

    public function admin() {}

    #[Title('Admin Details')]
    public function render()
    {
        return view('livewire.admin.admin-details')->extends('layouts.admin_layout')->section('admin-section');
    }

    public function getAdminDetails()
    {
        $user = Admin::find($this->adminID);
        // dd($user);
        $this->admin = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->balance = $user->balance;

    }

    public function addAdminFund() {
        $admin = Admin::find($this->adminID);
        $admin->balance += $this->amount;
        $admin->save();
        $this->reset('amount');
        $this->balance = $admin->balance;
        $this->dispatch('alert', type: 'success', text: 'Admin fund added successfully.', position: 'center', timer: 10000, button: false);

    }

    public function updateAdminAccount(){
        $admin = Admin::find($this->adminID);
        // dd($admin);
        $admin->first_name = $this->first_name;
        $admin->last_name = $this->last_name;
        $admin->email = $this->email;
        $admin->phone_number = $this->phone_number;
        $admin->role = $this->role;
        $admin->status = $this->status;
        $admin->save();
        $this->dispatch('alert', type: 'success', text: 'Admin account updated successfully.', position: 'center', timer: 10000, button: false);

        // session()->flash('success', 'Admin account updated successfully');
        // $this->reset(['first_name', 'last_name', 'email', 'phone_number', 'role','status']);
    }
}




//     "id" => 12
//     "first_name" => "kakado"
//     "last_name" => "Alright"
//     "email" => "Grtt@gmai.lcom"
//     "phone_number" => "078070797966"
//     "email_verified_at" => null
//     "password" => "$2y$12$PTybiKAAwOa3DsGk/l.cD.WZ5oB6bubZBE/xVMaIIYvL3WWfF0Hvq"
//     "role" => "admin"
//     "status" => "pending"
//     "otp" => null
//     "otp_expired_at" => null
//     "created_at" => "2025-02-15 22:30:15"
//     "updated_at" => "2025-02-15 22:30:15"
//   ]