<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use App\User;
use App\Vocher;
use App\Vocher_details;
use Illuminate\Http\Request;

class VocherController extends Controller
{

    public function create(){

        $payments=Payment::all();
        $projects=Project::all();
        $users=User::all();
        $details=Payment_details::all();
        //$paid_amounts = PaymentDetailsController::with('payment_id')->where('project_id', 1)->get();
//        $paid_amounts=Payment_details::Where('project_id','payment_id')->get();


     return  view('voucher.create',['payments'=>$payments,'projects'=>$projects,'users'=>$users ]);
    }


    public function store(Request $request){

        $amount=$request->amount;

        $vocher=new Vocher();
        $vocher->total_amount=array_sum($amount);
      //  $vocher->payment_id=$request->payment_id;
        $vocher->user_id=$request->user_id;

        if($request->hasFile('file')){
            $vocher->file=$request->file->store('/public/voucher');
        }
        $vocher->save();
        $projects=$request->project_id;
        $payments=$request->payment_id;

        foreach ($payments as $key=>$payment){
            $vocherDetails = new Vocher_details();
            $vocherDetails->project_id = $projects[$key];
            $vocherDetails->payment_id = $payment;
            $vocherDetails->amount = $amount[$key];
            $vocher->Vocher_details()->save($vocherDetails);
        }

        $this->GenerateVocherId($vocher);



       // $vocher->save();
       return redirect()->route('voucher_create');
    }

    private function GenerateVocherId(Vocher $vocher){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($vocher->id,4, '0', STR_PAD_LEFT));
//        $generateCertificate = "V-{$sequentialId}";
        $vocher->voucher_id=$sequentialId;
        $vocher->save();
    }


    Public function index(){

      $vochers=Vocher::all();
        return  view('voucher.index',['vochers'=>$vochers]);
    }

    public function edit ($id){

        $vochers=Vocher::find($id);
        $payments=Payment::all();
        $projects=Project::all();


        return view('voucher.edit',['vochers'=>$vochers,'payments'=>$payments,'projects'=>$projects]);

    }


    public function update(Request $request,$id){

        $vocher=Vocher::find($id);

        $vocher->amount=$request->amount;
        $vocher->payment_id=$request->payment_id;
        $vocher->project_id=$request->project_id;
        $vocher->save();

    }

    public function  delete($id){
        $vocher=Vocher::find($id);
        $vocher->delete();
        return redirect()->route('voucher_index');
    }



}
