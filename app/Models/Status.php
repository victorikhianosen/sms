<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $guarded = [];

    protected $table = 'status';


    public function users() {
        return $this->hasMany(User::class);
    }
}
