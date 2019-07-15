<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function company(){

        return $this->belongsTo('App\Company');

    }

    public function Payment(){
        return $this->hasMany('App\Payment');

    }

}
