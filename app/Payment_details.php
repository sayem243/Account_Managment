<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_details extends Model
{
    public function Payment(){
        return $this->belongsTo('App\Payment');
    }

    public function project(){
        return $this->belongsTo('App\Project')->withTrashed();
    }

  /*public function voucher_details(){

      return $this->hasMany('App\Vocher_details');
  }*/

}
