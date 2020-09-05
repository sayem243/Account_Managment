<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckRegistry extends Model
{

    public function company(){

        return $this->belongsTo('App\Company','company_id')->withTrashed();
    }

    public function bankAccount(){

        return $this->belongsTo('App\BankAccount')->withTrashed();
    }
    public function bank(){

        return $this->belongsTo('App\BankAndBranch','bank_id')->withTrashed();
    }
    public function branch(){

        return $this->belongsTo('App\BankAndBranch','branch_id')->withTrashed();
    }
    public function cashTransaction(){

        return $this->belongsTo('App\CashTransaction','cash_transaction_id');
    }
}
