<?php

namespace App\Models;

use App\Models\MobileNetwork;
use App\Models\UssdShortCode;
use Illuminate\Database\Eloquent\Model;

class UserShortCode extends Model
{
    protected $guarded = [];

    protected $table = 'user_short_codes';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ussdshortcode()
    {
        return $this->hasMany(UssdShortCode::class);
    }

    public function mobilenetwork()
    {
        return $this->belongsTo(MobileNetwork::class);
    }


}
