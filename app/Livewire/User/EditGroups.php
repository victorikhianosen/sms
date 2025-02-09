<?php

namespace App\Livewire\User;

use App\Models\Group;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

class EditGroups extends Component
{
    public $groupId; // Store the group ID

    #[Validate('required|string|max:70')]
    public $name;

    #[Validate('required|string|max:70')]
    public $description;

    // Updated regex to allow multiple spaces or no space after commas
    #[Validate('required|string')]
    public $numbers;

    #[Title('Edit Groups')]
    public function mount($id)
    {
        $group = Group::findOrFail($id); // Retrieve the group by ID

        // Set the values to individual properties
        $this->groupId = $group->id;
        $this->name = $group->name;
        $this->description = $group->description;

        // Decode the JSON string into an array if needed
        if (is_string($group->numbers)) {
            // Decode the JSON string into an array
            $numbersArray = json_decode($group->numbers, true);
            // Implode the array into a comma-separated string
            $this->numbers = implode(' , ', $numbersArray);
        }
    }

    public function render()
    {
        return view('livewire.user.edit-groups')->extends('layouts.auth_layout')->section('auth-section');
    }

    public function updateGroup()
    {
        // Step 1: Validate the input based on the regex and uniqueness
        $validated = $this->validate();


        // Step 2: Extract the numbers and ensure each is 11 digits
        $numbersArray = array_map('trim', explode(',', $this->numbers));

        // Step 3: Filter out numbers that are not 11 digits or duplicates
        $uniqueNumbers = array_filter($numbersArray, function ($number) {
            return preg_match('/^\d{11}$/', $number);
        });

        // Ensure the numbers are unique
        $uniqueNumbers = array_unique($uniqueNumbers);

        // Step 4: JSON encode the filtered unique numbers
        $validated['numbers'] = json_encode(array_values($uniqueNumbers));

        // Step 5: Update the group with the validated data
        $group = Group::findOrFail($this->groupId);
        $group->update($validated);

        // Dispatch success message
        $this->dispatch('alert', type: 'success', text: 'Group Update Successful!', position: 'center', timer: 10000, button: false);
        return $this->redirectRoute('groups', navigate:true);
    }
}
