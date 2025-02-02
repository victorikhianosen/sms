<?php

namespace App\Models;

use App\Models\SmsSender;
use Illuminate\Database\Eloquent\Model;

class SmsRoute extends Model
{
    public function smssender()
    {
        return $this->hasMany(SmsSender::class);
    }
}
