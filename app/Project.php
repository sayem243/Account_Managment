<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Project extends Model
{

    public function company(){

        return $this->belongsTo('App\Company')->withTrashed();
    }

    public function Payment(){
        return $this->hasMany('App\Payment');

    }

    public function payment_details(){

        return $this->hasMany('App\Payment_details');
    }

    public function amendment(){

        return $this->hasMany('App\Ammendment');
    }

    public function paymentSettlements(){
        return $this->hasMany('App\PaymentSettlement');
    }

    public  function users(){

        return $this->belongsToMany('App\User');
    }


    public function vocher(){

        return $this->hasMany('App\Vocher');
    }

//    public function vocher_details(){
//
//        return $this->hasMany('App\Vocher_details');
//    }
    use SoftDeletes;
}
