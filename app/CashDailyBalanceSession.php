<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashDailyBalanceSession extends Model
{
    public function company(){

        return $this->belongsTo('App\Company','company_id')->withTrashed();
    }
}
