<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Title;

class MessageList extends Component
{

    public $editModel = false;

    public $search = '';

    #[Title('All Messages')]
    public function render()
    {
        // $messages = Message::latest()->paginate(3);


           $payments = Payment::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('amount', 'like', $this->search)  // Exact match
                        ->orWhere('amount', 'like', $this->search . '%')  // Starts with
                        ->orWhere('amount', 'like', '%' . $this->search); // Ends with
                });
            })

        return view('livewire.admin.message-list', compact('messages'))
            ->extends('layouts.admin_layout')
            ->section('admin-section');
    }

}




        // "id" => 1
        // "user_id" => 1
        // "admin_id" => null
        // "sms_sender_id" => 1
        // "sender" => "PROPERTY NG"
        // "page_number" => "1"
        // "page_rate" => "3.00"
        // "status" => "sent"
        // "amount" => "3"
        // "message" => "Testing"
        // "message_id" => "05bd3a20-b536-4c69-a205-7f17260f942b"
        // "destination" => "2347033274155"
        // "route" => "EXCH-PRO"
        // "created_at" => "2025-02-17 14:49:44"
        // "updated_at" => "2025-02-17 14:49:44"