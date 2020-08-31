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
}
