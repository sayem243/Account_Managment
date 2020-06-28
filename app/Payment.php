<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Payment extends Model
{

    public function user(){

        return $this->belongsTo('App\User')->withTrashed();
    }
    public function company(){

        return $this->belongsTo('App\Company')->withTrashed();
    }

    public function project(){

        return $this->belongsTo('App\Project')->withTrashed();
    }

    public function userCreatedBy(){

        return $this->belongsTo('App\User','created_by');
    }

    public function approvedBy(){

        return $this->belongsTo('App\User','approved_by');
    }

    public function disbursedBy(){

        return $this->belongsTo('App\User','disbursed_by');
    }

    public function verifiedBy(){
        return $this->belongsTo('App\User','verified_by');
    }

    public function usertype(){
        return $this->belongsTo('App\UserType');
    }

    public function ammendments(){
        return $this->hasMany('App\Ammendment');
    }

    public function paymentSettlements(){
        return $this->hasMany('App\PaymentSettlement');
    }

    public function paymentDocuments(){
        return $this->hasMany('App\Documents');
    }

    public function paymentTransfers(){
        return $this->hasMany('App\PaymentTransfer','payment_id');
    }

    public function referencePayment(){
        return $this->hasMany('App\PaymentTransfer','reference_payment_id');
    }

    public function Payment_details(){
        return $this->hasMany('App\Payment_details');
    }
    public function vocher(){
        return $this->belongsTo('App\Vocher');
    }

    public function Vocher_details(){

        return $this->hasMany('App\Vocher_details');
    }

    public function voucherItems(){

        return $this->hasMany('App\VoucherItems');
    }

    public function getTotalPaidAmount(){
        $amount=0;
        foreach ($this->Payment_details as $payment_detail){
            $amount+=$payment_detail->paid_amount;
        }
        return $amount;
    }

    public function getTotalPaymentSettlementAmount(){
        $settlementAmount=0;
        foreach ($this->paymentSettlements as $paymentSettlement){
            $settlementAmount+=$paymentSettlement->settlement_amount;
        }
        return $settlementAmount;
    }


}
