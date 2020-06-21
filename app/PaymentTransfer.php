<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransfer extends Model
{
    //
    public  function payment(){
        return $this->belongsTo('App\Payment','payment_id');
    }

    public  function referencePayment(){
        return $this->belongsTo('App\Payment','reference_payment_id');
    }
}
