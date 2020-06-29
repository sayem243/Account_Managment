<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherItems extends Model
{
    public function voucher(){

        return $this->belongsTo('App\Voucher');
    }

    public function payment(){

        return $this->belongsTo('App\Payment');
    }
    public function project(){

        return $this->belongsTo('App\Project');
    }
}
