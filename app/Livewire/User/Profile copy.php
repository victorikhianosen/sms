<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $current_valid_id; // This will hold the existing file path

    public $email;
    public $profile_picture;
    public $address;
    public $company_name;
    public $phone;
    public $status;

    public $image;

    public $valid_id;

    #[Title('Profile')]
    public function render()
    {
        $user = Auth::user();

        $this->first_name = $user['first_name'];
        $this->last_name = $user['last_name'];
        $this->email = $user['email'];
        $this->current_valid_id = $user['valid_id']; // Changed this line
        $this->profile_picture = $user['profile_picture'];
        $this->address = $user['address'];
        $this->company_name = $user['company_name'];
        $this->company_name = $user['company_name'];
        $this->phone = $user['phone'];
        $this->status = $user['status'];


        return view('livewire.user.profile')->extends('layouts.auth_layout')
            ->section('auth-section');
    }

    public function ProfileUpdate()
    {
        if (!$this->image) {
            $this->dispatch('alert', type: 'error', text: 'Please select an image first.', position: 'center', timer: 10000, button: false);
            return;
        }


        $user = Auth::user();

        // Store the uploaded image in the 'profile_pictures' directory in the 'public' disk
        $filePath = $this->image->store('profile_pictures', 'public');
        $filePathvalid = $this->valid_id->store('valid_id', 'public');


        // Update only the profile picture
        $user->profile_picture = $filePath;
        $user->valid_id = $filePathvalid;

        $user->save();

        $this->dispatch('alert', type: 'success', text: 'Profile updated successfully.', position: 'center', timer: 10000, button: false);
    }
}
