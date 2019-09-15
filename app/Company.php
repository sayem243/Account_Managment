<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    public function account(){

        return $this->hasMany('App\Account');
    
    }

    public  function  project(){
        return $this->hasMany('App\Project');
    }

    public function Payment(){
        return $this->hasMany('App\Payment');
    }

    public function userProfile(){

        return $this->hasMany('App\UserProfile');

    }



     use SoftDeletes;


}


  

