<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;

class AllGeneralLedger extends Component
{
    use WithPagination;
    #[Title('Group List')]

    // public $ledgers; 

    public function render()
    {
        // $this->ledgers =
        return view('livewire.admin.all-general-ledger',[
            'ledgers' =>  GeneralLedger::latest()->paginate(perPage: 10)
        ])->layout('layouts.admin_layout');
    }
}
