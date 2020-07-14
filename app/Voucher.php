<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    public function VoucherItems(){

        return $this->hasMany('App\VoucherItems');
    }

    public function expenditureSector(){

        return $this->belongsTo('App\ExpenditureSector');
    }

    public function getTotalAmount(){
        $amount=0;
        foreach ($this->VoucherItems as $voucherItem){
            $amount+=$voucherItem->voucher_amount;
        }
        return $amount;
    }
}
