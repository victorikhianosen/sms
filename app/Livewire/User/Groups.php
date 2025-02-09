<?php

namespace App\Livewire\User;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;  // Add the pagination trait
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Services\NumberExtractorService;

class Groups extends Component
{
    use WithFileUploads;
    use WithPagination; // Add pagination handling

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:70')]
    public $description;

    #[Validate('required|file|mimes:csv,xls,xlsx')]
    public $numbers;

    public $showModal = false;
    protected $numberExtractor;

    public function __construct()
    {
        $this->numberExtractor = app(NumberExtractorService::class);
    }

    #[Title('Groups')]
    public function render()
    {

        $userID = Auth::id();
        $allGroups = Group::where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            
        // Fetch groups with pagination and pass it to the view
        return view('livewire.user.groups', [
            'allGroups' => $allGroups,
        ])->extends('layouts.auth_layout')->section('auth-section');
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }


    public function addGroup()
    {
        $validated = $this->validate();

        // Save the uploaded file
        $filePath = $this->numbers->store('uploads/groups', 'public');
        $validated['user_id'] = Auth::id();

        // Extract numbers using the service
        $fileFullPath = storage_path("app/public/{$filePath}");
        $extension = $this->numbers->getClientOriginalExtension();
        $validated['numbers'] = $this->numberExtractor->extractNumbersAsJson($fileFullPath, $extension);

        // Create the group in the database
        Group::create($validated);

        $this->reset(['name', 'description', 'numbers']);
        $this->closeModal();


        $this->dispatch('alert', type: 'success', text: 'Upload Successful!', position: 'center', timer: 10000, button: false);
    }


    public function deletGroup($id)
    {
        $user = Auth::user();

        $group = Group::find($id);

        if ($group && $group->user_id === $user->id) {
            $group->delete();

            $this->dispatch('alert', type: 'success', text: 'Group deleted successfully!', position: 'center', timer: 10000, button: false);
        } else {
            $this->dispatch('alert', type: 'error', text: 'You are not authorized to delete this group!', position: 'center', timer: 10000, button: false);
        }
    }

}
