<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }


//    public function users(){
//
//
//        return $this->hasOne('App\Payment');
//
//
//    }
}
