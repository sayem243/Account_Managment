<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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



}
