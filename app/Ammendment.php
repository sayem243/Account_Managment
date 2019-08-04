<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ammendment extends Model
{
    public  function payment(){

        return $this->belongsTo('App\Payment');

    }



//$amendment = DB::table('ammendments')
//->select(DB::raw('count(*) as additional_amount, payment_id'))
//    //->where('status', '<>', 1)
//->groupBy('additional_amount+payment->id')
//->get();
//

}
