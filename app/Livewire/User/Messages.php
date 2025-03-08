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

    public $search = '';
    
    #[Title('Messages')]
    public function render()
    {
        $userID = Auth::id();
        $allMessage = Message::where('user_id', $userID)
            ->when($this->search, function ($query) {
                $searchTerm = $this->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('message_id', 'like', "%{$searchTerm}%")
                        ->orWhere('destination', 'like', "%{$searchTerm}%")
                        ->orWhere('status', 'like', "%{$searchTerm}%")
                        ->orWhere('created_at', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(4);
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
