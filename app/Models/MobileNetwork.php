<?php

namespace App\Models;

use App\Models\UserShortCode;
use Illuminate\Database\Eloquent\Model;

class MobileNetwork extends Model
{

    protected $guarded = [];

    public function usershortcodes()
    {
        return $this->hasMany(UserShortCode::class);
    }

    public function ussdusages()
    {
        return $this->hasMany(UssdUsage::class);
    }
}

