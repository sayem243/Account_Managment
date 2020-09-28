<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashTransaction extends Model
{


    public static function insertData($data){
        self::insert($data);

        return DB::getPDO()->lastInsertId();
    }


    public function getDailyBalanceTransaction($date, $company_id){
        $from_date = $date? $date.' 00:00:00': '';
        $to_date = $date? $date.' 23:59:59': '';
        $rows = DB::table('cash_transactions');
        if ($company_id!=''){
            $rows->where('company_id', $company_id);
        }
        $rows->whereIn('cash_transactions.transaction_via',[
            'CHECK_OUT',
            'INCOME_CASH',
            'INCOME_CHECK_CASH',
            'LOAN_CASH',
            'LOAN_CHECK_CASH',
            'HAND_SLIP_SETTLE',
            'HAND_SLIP_TRANSFER',
            'HAND_SLIP_CASH_RETURN',
            'HAND_SLIP_ISSUE',
            'VOUCHER',
        ]);
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $result = $rows->get();
        $returnArray = array();

        foreach ($result as $cashTransaction){
            $returnArray[$cashTransaction->company_id][$cashTransaction->transaction_type][]=$cashTransaction->amount;
        }
        return $returnArray;
    }
}
