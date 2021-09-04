<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
