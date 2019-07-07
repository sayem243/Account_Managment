<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function companies(){
        return $this->belongsTo('App\Company');
    }


}
