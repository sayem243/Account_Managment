<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    public function checkRegistryLoanFrom(){
        return $this->belongsTo('App\CheckRegistry','check_registry_id_for_loan_from');
    }
    public function checkRegistryLoanTo(){
        return $this->belongsTo('App\CheckRegistry','check_registry_id_for_loan_to');
    }
}
