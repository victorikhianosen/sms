<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SmsProvider;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class SmsProviderList extends Component
{
    use WithPagination;

    #[Title('Sms Provider List')]
    public function render()
    {
        $providers = SmsProvider::latest()->paginate(10);

        return view('livewire.admin.settings.sms-provider-list', [
            'providers' => $providers,
        ])
            ->extends('layouts.admin_layout')
            ->section('admin-section');
    }


    public function updateStatus($providerId, $newStatus)
    {
        $provider = SmsProvider::findOrFail($providerId);

        if ($newStatus === 'active') {
            // Deactivate all providers first
            SmsProvider::where('id', '!=', $providerId)->update(['is_active' => 0]);

            // Activate selected provider
            $provider->is_active = 1;
            $provider->save();

            $this->dispatch('alert', type: 'success', text: 'Set as active successfully.', position: 'center', timer: 10000, button: false);
        } elseif ($newStatus === 'inactive') {
            $provider->is_active = 0;
            $provider->save();

            $this->dispatch('alert', type: 'success', text: 'Set as inactive successfully.', position: 'center', timer: 10000, button: false);
            return;
        }
    }
}
