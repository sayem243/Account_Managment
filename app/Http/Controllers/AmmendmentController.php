<?php

namespace App\Http\Controllers;

use App\Ammendment;
use Illuminate\Http\Request;
use App\Payment;

class AmmendmentController extends Controller
{

    public function index(){

        $amendments=Ammendment::all();

        return view('ammendment.index')->with('amendments',$amendments);

    }

    public function create($id){


        $payment=Payment::find($id);

        return view('ammendment.create')->with('payment',$payment);
    }


    public function store(Request $request){

        $amendment=new Ammendment;

        $amendment->additional_amount=$request->additional_amount;
        $amendment->approved="approved";


        $amendment->save();
        return redirect()->route('amendment');


    }

}
