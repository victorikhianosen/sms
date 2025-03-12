<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function smsender()
    {
        return $this->belongsTo(SmsSender::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }


}
