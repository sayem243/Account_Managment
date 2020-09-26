<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashDailyBalanceSession extends Model
{
    public function company(){

        return $this->belongsTo('App\Company','company_id')->withTrashed();
    }

    public function getDailyOpeningClosingBalance($from_date,$to_date, $company_id){
        $rows = DB::table('cash_daily_balance_sessions');
        if ($company_id!=''){
            $rows->where('company_id', $company_id);
        }
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $rows->orderBy('id', 'ASC');
        $result = $rows->get();
        $returnData = array();

        foreach ($result as $value){
            $returnData[$value->company_id]=$value;
        }
        return $returnData;
    }
}
