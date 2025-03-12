<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Payment;
use App\Models\GeneralLedger;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    
    public function ledger()
    {
        return $this->belongsTo(GeneralLedger::class, 'general_ledger_id');
    }

    public function scheduledMessage()
    {
        return $this->belongsTo(ScheduledMessage::class);
    }
}
