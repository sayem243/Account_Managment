<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentComments extends Model
{
    public function payment(){
        return $this->belongsTo('App\Payment');
    }

    public function user(){

        return $this->belongsTo('App\User','created_by');
    }
}
