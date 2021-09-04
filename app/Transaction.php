<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function source(){

        return $this->belongsTo(User::class,'source_id','id');
    }
}
