<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentSettlement;
use App\VoucherItems;
use Illuminate\Http\Request;

class PaymentSettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:payment-settlement-list', ['only' => ['index']]);
        $this->middleware('permission:payment-settlement-create', ['only' => ['store']]);
        $this->middleware('permission:payment-settlement-delete',['only'=>['delete']]);
    }


    public function index(){
        $settlements=PaymentSettlement::all();

        return view('settlement.index',['settlements'=>$settlements]);

    }


    public function store(Request $request ,$id){

        $payment=Payment::find($id);

        $settlement = new PaymentSettlement();

        $settlement->settlement_amount= $request->settlement_amount;
        $settlement->payment_id= $payment->id;
        $settlement->project_id= $payment->project->id;
        $settlement->type= 'SETTLE';

        $settlement->save();

        if(sizeof($payment->voucherItems)<1){
            foreach ($payment->Payment_details as $payment_detail){
                $voucherItem= new VoucherItems();
                $voucherItem->item_name= $payment_detail->item_name;
                $voucherItem->payment_amount= $payment_detail->paid_amount;
                $voucherItem->voucher_amount= $payment_detail->paid_amount;
                $voucherItem->payment_id= $payment->id;
                $voucherItem->payment_details_id = $payment_detail->id;
                $voucherItem->project_id = $payment_detail->project->id;
                $voucherItem->save();
            }
        }

        $totalSettleAmount = $this->getTotalSettlementAmount($payment);

        if($payment->total_paid_amount>$totalSettleAmount){
            $payment->status = 5;
        }
        if($payment->total_paid_amount == $totalSettleAmount){
            $payment->status = 6;
        }
        $payment->save();


        return redirect()->route('details',$payment->id);
    }

    private function getTotalSettlementAmount(Payment $payment){
        return $payment->getTotalPaymentSettlementAmount();
    }


}
