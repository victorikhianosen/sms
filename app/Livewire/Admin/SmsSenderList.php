<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\SmsRoute;
use App\Models\SmsSender;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

class SmsSenderList extends Component
{
    use WithPagination;

    public $allUsers = [];
    public $allRoutes = [];

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $user;

    #[Validate('required')]
    public $route;

    #[Validate('required')]
    public $description;


    public $editModel = false;
    public $senderId;


    public function mount() {
        $this->allUsers = User::all();
        $this->allRoutes = SmsRoute::all();
        // dd($allUsers,s $allSenders);
    }

    #[Title('Admin Sender')]
    public function render()
    {
        $senders = SmsSender::latest()->paginate(10);
        // $this->allSenders = $senders;
        return view('livewire.admin.sms-sender-list', [
            'senders' => $senders
        ])->extends('layouts.admin_layout')->section('admin-section');
    }


    public function addNewsender() {
        $validated = $this->validate();
        SmsSender::create([
            'name' => $this->name,
            'user_id' => $this->user,
            'sms_route_id' => $this->route,
            'description' => $this->description
        ]);

        $this->dispatch('alert', type:'success', text: 'Sender added successfully.', position: 'center', timer: 10000, button: false);
        $this->reset(['name', 'user', 'route', 'description']);
    }


    public function editSender($id)
    {
        $sender = SmsSender::findOrFail($id);

        $this->senderId = $sender->id;
        $this->name = $sender->name;
        $this->user = $sender->user_id;
        $this->route = $sender->sms_route_id;
        $this->description = $sender->description;

        $this->editModel = true;
    }


    public function updateSender(){
        $validated = $this->validate();
        SmsSender::find($this->senderId)->update([
            'name' => $this->name,
            'user_id' => $this->user,
            'sms_route_id' => $this->route,
            'description' => $this->description
        ]);

        $this->dispatch('alert', type:'success', text: 'Sender updated successfully.', position: 'center', timer: 10000, button: false);
        $this->closeModal();
    }


    public function closeModal()
    {
        $this->editModel = false;
    }
    


    public function deleteSender($id) {
        // dd($id);
        SmsSender::find($id)->delete();

        $this->dispatch('alert', type: 'success', text: 'Sender deleted successfully.', position: 'center', timer: 10000, button: false);

    }


}
