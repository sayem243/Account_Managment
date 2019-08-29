<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Project extends Model
{
    public function company(){

        return $this->belongsTo('App\Company');

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


}
