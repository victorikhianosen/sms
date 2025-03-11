<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    protected $guarded = [];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }


    
}
