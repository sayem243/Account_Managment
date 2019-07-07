<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function accounts(){

        return $this->hasMany('App\Account','company_id');
    
    }
}


  

