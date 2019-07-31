<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ammendment extends Model
{
    public  function payment(){

        return $this->belongsTo('App\Payment');

    }


}
