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

    // public function render()
    // {
    //     $allSchedule = ScheduledMessage::query()
    //         ->when($this->search, function ($query) {
    //             $query->where(function ($q) {
    //                 $q->where('transaction_id', 'like', '%' . $this->search . '%')
    //                     ->orWhereHas('user', function ($query) {
    //                         $query->where('email', 'like', '%' . $this->search . '%');
    //                     })
    //                     ->orWhereHas('admin', function ($query) { // Search by admin email too
    //                         $query->where('email', 'like', '%' . $this->search . '%');
    //                     })
    //                     ->orWhere('amount', 'like', $this->search)
    //                     ->orWhere('amount', 'like', $this->search . '%')
    //                     ->orWhere('amount', 'like', '%' . $this->search);
    //             });
    //         })
    //         ->latest()
    //         ->paginate(10);

    //     return view('livewire.admin.schedule-message-list', compact('allSchedule'))
    //         ->extends('layouts.admin_layout')
    //         ->section('admin-section');
    // }


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
            ->paginate(2);

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
        // $this->destination = $schedule->destination;

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




 #attributes: array:15 [▼
//     "id" => 3
//     "user_id" => 1
//     "sms_sender_id" => 1
//     "sender" => "AssetMatrix"
//     "description" => "biro"
//     "page_number" => "1"
//     "page_rate" => "3"
//     "message" => "Testing Chwdule adminf"
//     "status" => "pending"
//     "amount" => "24.00"
//     "destination" => "["07063640410","70070707007"," 07070707077"," 70707769696"," 96969696969"," 69696969696"," 69968574748"," 83674848494"]"
//     "route" => "exchange_pro"
//     "scheduled_time" => "2025-03-13 17:55:00"
//     "created_at" => "2025-03-04 16:56:21"
//     "updated_at" => "2025-03-04 16:56:21"
//   ]