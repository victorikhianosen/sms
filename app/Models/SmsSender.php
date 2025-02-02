<?php

namespace App\Models;

use App\Models\SmsRoute;
use Illuminate\Database\Eloquent\Model;

class SmsSender extends Model
{
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function smsroute()
    {
        return $this->belongsTo(SmsRoute::class, 'sms_route_id'); // Ensure this matches the column name in the database
    }
}
