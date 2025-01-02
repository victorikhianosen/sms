<?php

namespace App\Models;

use App\Models\MobileNetwork;
use Illuminate\Database\Eloquent\Model;

class UssdUsage extends Model
{


    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }


    public function ussdshortcode()
    {
        return $this->belongsTo(UssdShortCode::class);
    }

    public function mobilenetwork()
    {
        return $this->belongsTo(MobileNetwork::class);
    }
}
