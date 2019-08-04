<?php

namespace App\Http\Controllers;

use App\Ammendment;
use Illuminate\Http\Request;
use App\Payment;
use App\Project;
use App\User;



class AmmendmentController extends Controller
{

    public function index(){

        $amendments=Ammendment::all();
        $payment=Payment::all();

        return view('ammendment.index',['amendments'=>$amendments,'payment'=>$payment ]);
       // return $amendment->groupBy(groupBy ,'payment_id');

    }

    public function create($id){


        $payment=Payment::find($id);

        return view('ammendment.create')->with('payment',$payment);
    }


    public function store(Request $request ,$id){

        $amendment=new Ammendment;

       // $payment=Payment::all();

        $payment=Payment::find($id);
        $amendment->additional_amount=$request->additional_amount;

        $amendment->payment_id=$payment->id;
        //$amendment->payment_id=$payment->id;

        $amendment->approved="approved";

        $amendment->save();


        return redirect()->route('amendment');










    }

}
