<?php

namespace App\Livewire\User;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class Messages extends Component
{
    use WithPagination;

    public $selectedMessage;

    #[Title('Messages')]
    public function render()
    {
        $userID = Auth::id();
        $allMessage = Message::where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->paginate(8); // Change number as needed

        return view('livewire.user.messages', compact('allMessage'))
            ->extends('layouts.auth_layout')
            ->section('auth-section');
    }

    public function showMessage($messageId)
    {
        $this->selectedMessage = Message::find($messageId);
        $this->dispatch('openModal');
    }

}
