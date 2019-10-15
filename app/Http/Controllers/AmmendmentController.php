<?php

namespace App\Http\Controllers;

use App\Ammendment;
use Illuminate\Http\Request;
use App\Payment;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;


class AmmendmentController extends Controller
{

        public function index(){

        $amendments=Ammendment::all();
        $payments=Payment::all();

//
         //$amendments=DB::table('ammendments')->where('payment_id', $id);
        //$payment=Payment::find($id);
        return view('ammendment.index',['amendments'=>$amendments,'payments'=>$payments]);

    }

    public function create($id){

        $payment=Payment::find($id);
        return view('ammendment.create')->with('payment',$payment);
    }

    public function store(Request $request ,$id){

        $payment=Payment::find($id);
        $payment->total_amendment_amount = ($payment->total_amendment_amount+array_sum($request->amendment_amount));

        $payment->save();


        foreach ($request->project_id as $key=>$project){
            if($request->amendment_amount[$key]>0){
                $amendment=new Ammendment;
                $amendment->amendment_amount=$request->amendment_amount[$key];
                $amendment->payment_id=$payment->id;
                $amendment->project_id=$project;
                $amendment->approved='approved';

                if($request->hasFile('file')){
                    $amendment->file=$request->file->store('/public/file');
                }

                $amendment->save();
            }
        }
        return redirect()->route('details',$payment->id);
    }
}
