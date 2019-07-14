<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function account(){

        return $this->hasMany('App\Account');

    }
    public function company(){

        return $this->hasMany('App\Company');

    }



}
