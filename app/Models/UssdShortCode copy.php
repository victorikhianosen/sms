<?php

namespace App\Models;

use App\Models\UssdUsage;
use App\Models\UserShortCode;
use Illuminate\Database\Eloquent\Model;

class UssdShortCode extends Model
{
    protected $table = 'ussd_short_codes';

    protected $guarded = [];


    public function usershortcode() {
        return $this->belongsTo(UserShortCode::class);
    }


    public function ussdusages()
    {
        return $this->hasMany(UssdUsage::class);
    }

}
