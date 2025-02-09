<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\ScheduledMessage;
use Illuminate\Support\Facades\Auth;

class ScheduleSmsView extends Component
{

    #[Title('View Schedule')]
    public function render()
    {

        $userID = Auth::id();
        $allSchedule = ScheduledMessage::where('user_id', $userID)
            ->whereNotIn('status', ['cancel', 'delete'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // dd($allSchedule);

        return view('livewire.user.schedule-sms-view', [
            'allSchedule' => $allSchedule
        ])->extends('layouts.auth_layout')->section('auth-section');
    }


    public function cancelSchedule($id)
    {

        $userID = Auth::id();
        $getSchedule = ScheduledMessage::where('user_id', $userID)
            ->where('id', $id)->first();
        // dd($message);

        if ($getSchedule['status'] !== 'pending') {
            $status  = $getSchedule['status'];
            $this->dispatch('alert', type: 'error', text: "Oops! Sorry, you can't cancel the $status messages.", position: 'center', timer: 10000, button: false);
        }

        $getSchedule->update(['status' => 'cancel']);

        $this->dispatch('alert', type: 'success', text: "Schedule canceled successfully.", position: 'center', timer: 10000, button: false);
    }
}
