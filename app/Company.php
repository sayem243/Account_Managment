<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function account(){

        return $this->hasMany('App\Account');
    
    }

    public  function  project(){
        return $this->hasMany('App\Project');
    }

    public function Payment(){
        return $this->belongsTo('App\Payment');

    }


}


  

