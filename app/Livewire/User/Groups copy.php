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

    protected $numberExtractor;

    public function __construct()
    {
        $this->numberExtractor = app(NumberExtractorService::class);
    }

    #[Title('Groups')]
    public function render()
    {
        // Fetch groups with pagination and pass it to the view
        return view('livewire.user.groups', [
            'allGroups' => Group::latest()->paginate(16),
        ])->extends('layouts.auth_layout')->section('auth-section');
    }

    // public function getGroup()
    // {
    //     // Ensure allGroups is populated with Group data
    //     $this->allGroups = Group::all();
    // }

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

        $this->dispatch('alert', type: 'success', text: 'Upload Successful!', position: 'center', timer: 10000, button: false);
    }
}
