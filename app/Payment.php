<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Payment extends Model
{

    public function user(){

        return $this->belongsTo('App\User');

    }
    public function company(){

        return $this->belongsTo('App\Company');

    }

    public function project(){

        return $this->belongsTo('App\Project');

    }
    public function userCreatedBy(){

        return $this->belongsTo('App\User','created_by');
    }

    public function usertype(){
        return $this->belongsTo('App\UserType');
    }

    public function ammendments(){
        return $this->hasMany('App\Ammendment');
    }

    public function Payment_details(){
        return $this->hasMany('App\Payment_details');
    }
    public function vocher(){
        return $this->belongsTo('App\Vocher');

    }

    public function Vocher_details(){

        return $this->hasMany('App\Vocher_details');

    }

}
