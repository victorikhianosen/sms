<?php

namespace App\Models;

use App\Models\UssdUsage;
use App\Models\UserShortcode;
use Illuminate\Database\Eloquent\Model;

class UssdShortcode extends Model
{
    protected $table = 'ussd_short_codes';

    protected $guarded = [];


    public function usershortcode()
    {
        return $this->belongsTo(UserShortCode::class);
    }


    public function ussdusages()
    {
        return $this->hasMany(UssdUsage::class);
    }
}
