<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class GroupList extends Component
{
    use WithPagination;

    public $editModel = false;

    public $email;
    public $name;
    public $description;
    public $numbers;
    public $created_at;

    // public $adminAllGroups = [];

    public function mount()
    {
        // $this->adminAllGroups = Group::all();
    }


    public function closeModal()
    {
        $this->editModel = false;
    }

    #[Title('Group List')]

    public function render()
    {
        // $adminAllGroups = Group::all();
        $adminAllGroups = Group::latest()->paginate(10);

        return view('livewire.admin.group-list', compact('adminAllGroups'))->extends('layouts.admin_layout')->section('admin-section');
    }

    public function viewGroup($id)
    {
        $this->editModel = true;
        $group = Group::find($id);
        $user = User::find($group->user_id);
        

        $this->email = $user->email;
        $this->name = $group->name;
        $this->description = $group->description;
        $this->numbers = $group->numbers;
        $this->created_at = $group->created_at;
        $this->numbers =    implode(', ', json_decode($this->numbers, true));


    }



    public function deleteGroup($id) {
        $group = Group::find($id);
        $group->delete();

        $this->dispatch('alert', type: 'success', text: 'Group Delete Successfully', position: 'center', timer: 10000, button: false);

    }

}
