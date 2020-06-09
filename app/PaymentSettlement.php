<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSettlement extends Model
{
    public  function payment(){

        return $this->belongsTo('App\Payment');
    }

    public function project(){

        return $this->belongsTo('App\Project');
    }
}
