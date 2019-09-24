<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Vocher extends Model
{

    public function payment(){

        return $this->hasMany('App\Payment');
    }

    public function project(){

        return $this->belongsTo('App\Project');
    }

    Public function user(){

        return $this->belongsTo('App\User');
    }

    public function Vocher_details(){

        return $this->hasMany('App\Vocher_details');
    }

    //
//    public function payments(){
//
//        return $this->belongsTo('App\Vocher');
//    }




}
