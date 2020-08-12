<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{


    public static function insertData($data){
        $cashTransaction = self::insert($data);

        return $cashTransaction;
    }
}
