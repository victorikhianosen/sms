<?php


namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class UserList extends Component
{
    use WithPagination;

    public $search;

    public $allUsers = [];

    #[Title('All Users')]


    public function render()
    {
        // $users = User::latest()->paginate(10);
        // dd($users);

        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-list', [
            'users' => $users
        ])->extends('layouts.admin_layout')->section('admin-section');
    }

    public function deleteUser($id)
    {
        $admin = User::find($id);
        $admin->delete();
        $this->dispatch('alert', type: 'success', text: 'User Account deleted successfully.', position: 'center', timer: 10000, button: false);
    }
}
