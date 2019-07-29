<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    public function company(){

        return $this->belongsTo('App\Company');
    }

    public function user(){

        return $this->belongsTo('App\User');
    }


}
