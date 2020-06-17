<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use App\User;
use App\Vocher;
use App\Vocher_details;
use Illuminate\Http\Request;
use DB;

class VoucherController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:Payment-create', ['only' => ['index','create','store','approve','verify']]);
        $this->middleware('permission:voucher_approved', ['only' => ['approved']]);
        $this->middleware('permission:voucher_create', ['only' => ['create']]);


    }


    public function create(){

        $payments=Payment::all();
        $projects=Project::all();
        $users=User::all();
     return  view('voucher.create',['projects'=>$projects,'users'=>$users ]);
    }

    public function store(Request $request){
        $amount=$request->amount;
        $vocher=new Vocher();
        $vocher->total_amount=array_sum($amount);
        $vocher->user_id=$request->user_id;

        $vocher->comments=$request->comments;

        $vocher->save();
        $projects=$request->project_id;
        $payments=$request->payment_id;

        $file=$request->files->get('filenames');

        foreach ($payments as $key=>$payment){
            if($payment>0){
                $vocherDetails = new Vocher_details();
                $vocherDetails->project_id = $projects[$key];
                $vocherDetails->payment_id = $payment;
                $vocherDetails->amount = $amount[$key];

                if($request->hasFile('filenames')){
                if($file[$key]->getClientOriginalName()){
                    $filename = $file[$key]->getClientOriginalName();
                    $modifyFilename=time() . "_" .$filename;
                    $vocherDetails->filenames=$modifyFilename;
                    $file[$key]->move(public_path() . '/files/',$modifyFilename);
                }
                }

                $vocher->Vocher_details()->save($vocherDetails);
            }

        }
            $this->GenerateVocherId($vocher);


       return redirect()->route('voucher_index');
    }

    private function GenerateVocherId(Vocher $vocher){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($vocher->id,4, '0', STR_PAD_LEFT));
//        $generateCertificate = "V-{$sequentialId}";
        $vocher->voucher_id=$sequentialId;
        $vocher->save();
    }


    Public function index(){

      $vochers=Vocher::orderBy('created_at','DSC')->paginate(25);
        return  view('voucher.index',['vochers'=>$vochers]);
    }

    public static function paidAmountByPaymentAndProject($payment, $project){
        $paymentDetails = DB::table('payment_details')
            ->where([
                ['payment_id', '=', $payment],
                ['project_id', '=', $project],
            ])
            ->get();
        $data=array();
        if($paymentDetails){
            $amount=0;
            foreach ($paymentDetails as $paymentDetail){

                $amount+=$paymentDetail->paid_amount;
            }
           $data['amount']=$amount;
        }

        $amendmentDetails=DB::table('ammendments')->where([
            ['payment_id','=',$payment],
            ['project_id','=',$project],
        ])->get();

        $value=array();
        if($amendmentDetails){
            $tk=0;
            foreach ($amendmentDetails as $amendmentDetail){

                $tk+=$amendmentDetail->amendment_amount;
            }
            $value['tk']=$tk;
        }

        return  $amount+$value['tk'];
    }
    public function edit ($id){

        $vochers=Vocher::find($id);
        $users=User::all();
        $payments=Payment::all();


        return view('voucher.edit',['vochers'=>$vochers,'payments'=>$payments ,'users'=>$users]);

    }

    public function update(Request $request,$id){

        $vocher=Vocher::find($id);
        $amount=$request->amount;
        $newAmount=$request->amount?$request->amount:array(0);
        $exitAmount = $request->exit_amount?$request->exit_amount:array(0);
        $vocher->total_amount=array_sum($newAmount)+array_sum($exitAmount);
        $vocher->user_id=$request->user_id;
        $vocher->comments=$request->comments;
        $exit_amount=$request->exit_amount;

//        if($request->hasFile('file')){
//          $vocher->file=$request->file->store('/public/voucher');
//        }
        $vocher->save();
        $projects=$request->project_id;
        $payments=$request->payment_id;
        $exit_payment_details=$request->exit_payment_detail;
        $file=$request->files->get('filenames');

        if($payments){
            foreach ($payments as $key=>$payment){
                if($payment>0){
                    $vocherDetails = new Vocher_details();
                    $vocherDetails->project_id = $projects[$key];
                    $vocherDetails->payment_id = $payment;
                    $vocherDetails->amount = $amount[$key];

                    if($request->hasFile('filenames')){
                        if($file[$key]->getClientOriginalName()){
                            $filename = $file[$key]->getClientOriginalName();
                            $modifyFilename=time() . "_" .$filename;
                            $vocherDetails->filenames=$modifyFilename;
                            $file[$key]->move(public_path() . '/files/',$modifyFilename);
                        }
                    }

                    $vocher->Vocher_details()->save($vocherDetails);
                }
                }
            }
        if($exit_payment_details){
            foreach ($exit_payment_details as $key=>$detail){
              $vocherDetails=Vocher_details::find($detail);

              $vocherDetails->project_id=$request->exit_project_id[$key];
              $vocherDetails->payment_id=$request->exit_payment_id[$key];
              $vocherDetails->amount=$exit_amount[$key];

                    if($request->hasFile('filenames')){
                        if($file[$key]->getClientOriginalName()){
                            $filename=$file[$key]->getClientOriginalName();
                            $modifyFilename=time() ."_".$filename;
                            $vocherDetails->filenames=$modifyFilename;
                            $file[$key]->move(public_path() . '/files/',$modifyFilename);
                        }
                    }
                    $vocher->Vocher_details()->save($vocherDetails);
                }
             }

//        $this->GenerateVocherId($vocher);
        return redirect()->route('voucher_index');
    }

    public function  delete($id){
        $vocher=Vocher::find($id);
        $vocher->delete();
        return redirect()->route('voucher_index');
    }



    public function approved($id){
        $voucher=Vocher::find($id);
        $voucher->status=2;
        $voucher->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

}
