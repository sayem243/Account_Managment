<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentSettlement;
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

        $settlement->save();

        return redirect()->route('details',$payment->id);
    }


}
