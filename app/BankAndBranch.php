<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAndBranch extends Model
{
    use SoftDeletes;

    public function branches(){
        return $this->hasMany('App\BankAndBranch','bank_id')->withTrashed();
    }

    public function bank(){

        return $this->belongsTo('App\BankAndBranch','bank_id')->withTrashed();
    }
}
