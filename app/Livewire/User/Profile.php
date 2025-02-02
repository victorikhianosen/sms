<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    use WithFileUploads;

    public $first_name, $last_name, $email, $address, $company_name, $phone, $status;
    public $profile_picture, $current_valid_id;
    public $image, $valid_id;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->profile_picture = $user->profile_picture;
        $this->current_valid_id = $user->valid_id;
        $this->address = $user->address;
        $this->company_name = $user->company_name;
        $this->phone = $user->phone;
        $this->status = $user->status;
    }

    public function uploadProfilePicture()
    {
        $this->validate([
            'image' => 'image|max:2048', // Max 2MB
        ]);

        $filePath = $this->image->store('profile_pictures', 'public');

        $user = Auth::user();
        $user->profile_picture = $filePath;
        $user->save();

        $this->profile_picture = $filePath; // Update UI

        $this->dispatch('alert', type: 'success', text: 'Profile picture updated.');
    }

    public function uploadValidID()
    {
        $this->validate([
            'valid_id' => 'image|max:2048', // Max 2MB
        ]);

        $filePath = $this->valid_id->store('valid_ids', 'public');

        $user = Auth::user();
        $user->valid_id = $filePath;
        $user->save();

        $this->current_valid_id = $filePath; // Update UI

        $this->dispatch('alert', type: 'success', text: 'Valid ID updated.');
    }

    public function updatedImage()
    {
        $this->uploadProfilePicture(); // Auto-upload when image is selected
    }

    public function updatedValidId()
    {
        $this->uploadValidID(); // Auto-upload when valid ID is selected
    }

    #[Title('Profile')]

    public function render()
    {
        return view('livewire.user.profile')->extends('layouts.auth_layout')->section('auth-section');
    }
}
