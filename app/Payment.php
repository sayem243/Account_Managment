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

    public function usertype()
    {
        return $this->belongsTo('App\UserType');
    }


    public function ammendment(){

        return $this->hasMany('App\Ammendment');
    }

    public function ammendments(){

        return $this->belongsTo('App\Ammendment');
    }










}
