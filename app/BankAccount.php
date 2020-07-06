<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;
    public function bank(){

        return $this->belongsTo('App\BankAndBranch','bank_id')->withTrashed();
    }
    public function branch(){

        return $this->belongsTo('App\BankAndBranch','branch_id')->withTrashed();
    }
    public function company(){

        return $this->belongsTo('App\Company','company_id')->withTrashed();
    }
}
