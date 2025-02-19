<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Title;

class MessageList extends Component
{


    public $sms_sender_id, $sender, $page_number, $page_rate, $status, $amount, $message, $message_id, $destination, $route, $created_at;

    public $editModel = false;

    public $email;

    public $search = '';



    #[Title('All Messages')]
    public function render()
    {
        // $messages = Message::latest()->paginate(8);


        $messages = Message::when($this->search, function ($query) {
            $searchTerm = $this->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('message_id', 'like', "%{$searchTerm}%")
                    ->orWhere('destination', 'like', "%{$searchTerm}%")
                    ->orWhere('status', 'like', "%{$searchTerm}%")
                    ->orWhere('created_at', 'like', "%{$searchTerm}%");
            });
        })->latest()->paginate(8);


        return view('livewire.admin.message-list', compact('messages'))
            ->extends('layouts.admin_layout')
            ->section('admin-section');
    }

    public function closeModal()
    {
        $this->editModel = false;
    }

    public function viewMessage($id)
    {

        $this->editModel = true;
        $message = Message::find($id);
        // dd($message);
        $this->email = $message->user->email;
        $this->sms_sender_id = $message->sms_sender_id;
        $this->sender = $message->sender;
        $this->page_number = $message->page_number;
        $this->page_rate = $message['page_rate'];
        $this->status = $message->status;
        $this->amount = $message->amount;
        $this->message = $message->message;
        $this->message_id = $message->message_id;
        $this->destination = $message->destination;
        $this->route = $message->route;
        $this->created_at = $message->created_at;
    }
}
