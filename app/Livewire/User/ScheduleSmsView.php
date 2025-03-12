<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\GeneralLedger;
use Livewire\Attributes\Title;
use App\Models\ScheduledMessage;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;

class ScheduleSmsView extends Component
{


    protected $referenceService;

    public function __construct()
    {
        $this->referenceService = app(ReferenceService::class);
    }


    #[Title('View Schedule')]
    public function render()
    {

        $userID = Auth::id();
        $allSchedule = ScheduledMessage::where('user_id', $userID)
            ->whereNotIn('status', ['cancel', 'delete'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // dd($allSchedule);

        return view('livewire.user.schedule-sms-view', [
            'allSchedule' => $allSchedule
        ])->extends('layouts.auth_layout')->section('auth-section');
    }

    public function cancelSchedule($id)
    {
        $user = Auth::user();
        $getSchedule = ScheduledMessage::where('user_id', $user['id'])
            ->where('id', $id)->first();

        if (!$getSchedule) {
            $this->dispatch('alert', type: 'error', text: "Schedule not found.", position: 'center', timer: 10000, button: false);
            return;
        }

        if ($getSchedule['status'] !== 'pending') {
            $status  = $getSchedule['status'];
            $this->dispatch('alert', type: 'error', text: "Oops! Sorry, you can't cancel the $status messages.", position: 'center', timer: 10000, button: false);
            return;
        }

        $reference = $this->referenceService->generateReference($user);

        $generalLedger = GeneralLedger::where('account_number', '99248466')->first();
        $getSchedule->update(['status' => 'cancel']);
        $user->update([
            'balance' => $user->balance + $getSchedule['amount']
        ]);
        if ($generalLedger) {
            $generalLedger->update([
                'balance' => $generalLedger->balance + $getSchedule['amount']
            ]);
        }
        Transaction::create([
            'user_id' => $user->id,
            'scheduled_message_id' => $getSchedule->id,
            'general_ledger_id' => $generalLedger->id ?? null,
            'amount' => $getSchedule['amount'],
            'transaction_type' => 'debit',
            'payment_method' => 'canceled_schedule_refund',
            'balance_before' => $user->balance - $getSchedule['amount'], // Before refund
            'balance_after' => $user->balance, // After refund
            'reference' => 'reference',
            'description' => "Schedule cancellation refund for Message ID: {$getSchedule->id}/ {$getSchedule->reference}/ {$user->email}/ {$user->id}",
            'status' => 'success',
        ]);

        $this->dispatch('alert', type: 'success', text: "Schedule canceled successfully and GL credited.", position: 'center', timer: 10000, button: false);
    }





    // public function cancelSchedule($id)
    // {

    //     $user = Auth::user();
    //     $getSchedule = ScheduledMessage::where('user_id', $user['id'])
    //         ->where('id', $id)->first();
    //     // dd($getSchedule['amount'], $user);

    //     if ($getSchedule['status'] !== 'pending') {
    //         $status  = $getSchedule['status'];
    //         $this->dispatch('alert', type: 'error', text: "Oops! Sorry, you can't cancel the $status messages.", position: 'center', timer: 10000, button: false);
    //     }


    //     $getSchedule->update(['status' => 'cancel']);

    //     $user->update([
    //         'balance' => $user->balance + $getSchedule['amount']
    //     ]);


    //     $this->dispatch('alert', type: 'success', text: "Schedule canceled successfully.", position: 'center', timer: 10000, button: false);
    // }
}
