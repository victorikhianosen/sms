<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ScheduledMessage;

class ScheduleMessageList extends Component
{
    use WithPagination;

    public $showModal = false;

    public $email;
    public $sender;
    public $description;
    public $page_number;
    public $page_rate;
    public $status;
    public $destination;
    public $scheduled_time;
    public $created_at;
    public $message;
    public $amount;
    public $route;

    public $search = '';
    
    #[Title('Payment List')]


    public function render()
    {
        $search = $this->search;
        $allSchedule = ScheduledMessage::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'like', '%' . $search . '%');
                    })
                        ->orWhere('sender', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhere('amount', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.schedule-message-list', compact('allSchedule'))
            ->extends('layouts.admin_layout')
            ->section('admin-section');
    }



    public function closeModal() {
        $this->showModal = false;
    }

    public function viewSchedule($id) {
        $this->showModal = true;

        $schedule = ScheduledMessage::find($id);
        
        $this->email = $schedule->user->email;
        $this->sender = $schedule->sender;
        $this->description = $schedule->description;
        $this->page_number = $schedule->page_number;
        $this->page_rate = $schedule->page_rate;
        $this->message = $schedule->message;
        $this->status = $schedule->status;
        $this->amount = $schedule->amount;
        $this->destination = implode(', ', is_string($schedule->destination) ? (json_decode($schedule->destination, true) ?: []) : ($schedule->destination ?: []));
        $this->scheduled_time = $schedule->scheduled_time;
        $this->created_at = $schedule->created_at;
        $this->route = $schedule->route;
    }


    public function CancelSchedule($id) {
     $schedule = ScheduledMessage::find($id);
     
     $schedule->status = 'cancel';
     $schedule->save();
    }


    public function PendSchedule($id)
    {
        $schedule = ScheduledMessage::find($id);
        $schedule->status = 'pending';
        $schedule->save();
    }

    


    
}
