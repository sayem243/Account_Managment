<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentSettlement;
use Illuminate\Http\Request;

class PaymentTransferredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request ,$id){

//        var_dump($request->retried_type);die;
        $payment=Payment::find($id);
        if ($request->retried_type=='RETURN'){

            $settlement = new PaymentSettlement();

            $settlement->settlement_amount = $request->transfer_amount;
            $settlement->payment_id = $payment->id;
            $settlement->project_id = $payment->project->id;
            $settlement->type = 'CASH';

            $settlement->save();

            $totalSettleAmount = $this->getTotalSettlementAmount($payment);

            if($payment->total_paid_amount>$totalSettleAmount){
                $payment->status = 5;
            }
            if($payment->total_paid_amount <= $totalSettleAmount){
                $payment->status = 6;
            }
            $payment->save();


            return redirect()->route('details',$payment->id);
        }
        $request->session()->put('reference_payment_id',$payment->id);
        $request->session()->put('transfer_amount',$request->transfer_amount);

        return redirect()->route('payment_create',http_build_query(['reference_payment_id'=>$payment->id]));




    }

    private function getTotalSettlementAmount(Payment $payment){
        return $payment->getTotalPaymentSettlementAmount();
    }


}