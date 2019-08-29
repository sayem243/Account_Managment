<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_details extends Model
{
    public function Payment(){
        return $this->belongsTo('App\Payment');
    }


    public function project(){

        return $this->belongsTo('App\Project');
    }





}
