<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Services\ApiCredentialService;


class UserDetails extends Component
{
    public $user;

    public $userID;
    public $first_name;
    public $last_name;
    public $email;

    #[Validate('required')]
    public $password;

    // public $password_confirmation;
    public $balance;
    public $status;
    public $profile_picture;
    public $valid_id;
    public $account_number;
    public $phone;
    public $address;
    public $company_name;
    public $otp;
    public $otp_expired_at;
    public $sms_rate;
    public $allUsers;
    public $api_key;
    public $api_secret;
    public $statusOptions = ['active', 'inactive', 'pending', 'cancel', 'delete'];


    #[Title('User Details')]

    public function mount($id) {
        $this->userID = $id;


    }
    public function render()
    {
        return view('livewire.admin.user-details')->extends('layouts.admin_layout')->section('admin-section');
    }

    public function getUserDetails() {
    //   dd( User::find($this->userID));

        $user = User::findOrFail($this->userID);

        // dd(        $this->profile_picture = $user->profile_picture);

        $this->allUsers = $user;
        // dd($user);
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        // $this->password = $user->password;
        $this->balance = $user->balance;
        $this->status = $user->status;
        $this->profile_picture = $user->profile_picture;
        $this->valid_id = $user->valid_id;
        $this->account_number = $user->account_number;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->company_name = $user->company_name;
        $this->otp = $user->otp;
        $this->otp_expired_at = $user->otp_expired_at;
        $this->sms_rate = $user->sms_rate;
        $this->api_key = $user->api_key;
        $this->api_secret = $user->api_secret;
        // dd($this->api_secret = $user->api_secret);

    }


    private function authorizeChanges()
    {
        $user = Auth::guard('admin')->user();

        if (!$user || !in_array($user->role, ['super_admin', 'admin'])) {
            session()->flash('alert', [
                'type' => 'error',
                'text' => 'Unauthorized action.',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);

            abort(404); // Show 404 Page
        }
    }


    public function ChangePassword() {

        $this->authorizeChanges();

        $this->validate();
        $user = User::find($this->userID);
        // dd($this->password);
        $user->update([
            'password' =>  bcrypt($this->password)
        ]);

        $this->dispatch('alert', type: 'success', text: 'Password Updated successfully.', position: 'center', timer: 10000, button: false);

    }

    public function updateProfile() {
        $this->authorizeChanges();

        $this->validate([
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>'required|email|unique:users,email,'.$this->userID,
            'phone' =>'required|numeric|unique:users,phone,'.$this->userID,
            'address' =>'required',
            'company_name' =>'required',
            'valid_id' =>'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find($this->userID);
        
    }


    public function updateUserKey(ApiCredentialService $apiCredentialService)
    {
        $user = User::find($this->userID);

        if (!$user) {
            session()->flash('alert', [
                'type' => 'error',
                'text' => 'User not found.',
                'position' => 'center',
                'timer' => 4000,
                'button' => false,
            ]);
            return;
        }

        $apiCredentialService->generateApiCredentials($user);

        $this->api_key = $user->api_key;
        $this->api_secret = $user->api_secret;
        $this->dispatch('alert', type: 'success', text: 'API credentials regenerated successfully.', position: 'center', timer: 10000, button: false);
    }


    public function updateUserAccount()
    {
        $user = User::find($this->userID);

        if ($user) {
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'balance' => $this->balance,
                'status' => $this->status,
                'account_number' => $this->account_number,
                'phone' => $this->phone,
                'address' => $this->address,
                'company_name' => $this->company_name,
                'otp' => $this->otp,
                'otp_expired_at' => $this->otp_expired_at,
                'sms_rate' => $this->sms_rate,
            ]);

            $this->dispatch('alert', type: 'success', text: 'User profile updated successfully.', position: 'center', timer: 10000, button: false);

        } else {

            $this->dispatch('alert', type: 'error', text: 'User not found.', position: 'center', timer: 10000, button: false);

        }
    }






}
