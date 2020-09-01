<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    public function company(){

        return $this->belongsTo('App\Company','company_id')->withTrashed();
    }
    public function checkRegistry(){
        return $this->belongsTo('App\CheckRegistry','check_registry_id');
    }
}
