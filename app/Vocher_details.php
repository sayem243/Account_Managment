<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vocher_details extends Model
{
    public function vocher(){

        return $this->belongsTo('App\Vocher');
    }

    public function project(){
        return $this->belongsTo('App\Project');

    }

    public function payment(){

        return $this->belongsTo('App\Payment');
    }

     public function payment_details(){
        return $this->belongsTo('App\Payment_details');
     }


}
