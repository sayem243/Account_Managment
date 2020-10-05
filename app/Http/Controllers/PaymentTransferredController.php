<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\Notifications\HandSlipStatusNotification;
use App\Payment;
use App\PaymentSettlement;
use App\Service\SmsGateWay;
use Illuminate\Http\Request;

class PaymentTransferredController extends Controller
{
    protected $smsGateWay;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');

        $this->smsGateWay= new SmsGateWay();
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

            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'HAND_SLIP_CASH_RETURN',
                'transaction_via_ref_id'=>$payment->id,
                'amount'=>$settlement->settlement_amount,
                'company_id'=>$payment->company_id,
                'project_id'=>$settlement->project_id?$settlement->project_id:null,
                'created_by'=>auth()->id(),
                'created_at'=>new \DateTime(),
            );
            CashTransaction::insertData($arrayData);

            $data = array(
                'payment_id' => $payment->id,
                'generate_payment_id' => $payment->payment_id,
                'message' => 'Hand Slip settle by cash return.',
                'amount' => $payment->total_paid_amount,
            );

            auth()->user()->notify(new HandSlipStatusNotification($data));

            $payment->user->notify(new HandSlipStatusNotification(array('payment_id'=>$payment->id,'generate_payment_id' => $payment->payment_id,'message'=>'Your advance amount has been settle tk.'.$settlement->settlement_amount.' by cash return','amount' => $payment->total_paid_amount,)));
            $phone = $payment->user->UserProfile?$payment->user->UserProfile->mobile:'';
            if($phone){
                $this->smsGateWay->send('আপনের #'.$payment->payment_id.' হ্যান্ডস্লিপের '.$settlement->settlement_amount.' টাকা সমন্বয় করা হলো।',$phone);
            }


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
