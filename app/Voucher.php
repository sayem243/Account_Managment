<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function VoucherItems(){

        return $this->hasMany('App\VoucherItems');
    }

    public function getTotalAmount(){
        $amount=0;
        foreach ($this->VoucherItems as $voucherItem){
            $amount+=$voucherItem->voucher_amount;
        }
        return $amount;
    }
}
