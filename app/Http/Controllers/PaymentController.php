<?php

namespace App\Http\Controllers;

use App\Ammendment;
use App\Payment_details;
use App\Project;
use App\User;
use App\UserType;
use Illuminate\Http\Request;
use App\Payment;
use App\Company;
use App\Account;
use PDF;
use DB;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:Payment-create', ['only' => ['index','create','store']]);
    }

    public function index(){

        $payments=Payment::orderBy('created_at','DSC')->paginate(25);

        $amendments=Ammendment::all();

        return view('payment.payment_index',['payments'=>$payments,'amendments'=>$amendments])->with('i', (request()->input('page', 1) - 1) * 25);
    }

    public function create(){

       //$users=User::where('user_types_id',2)->get();
       $users=User::all();

       // $users=DB::users('user_types_id')->get();

      // $userprojects=DB::project_user('project_id')->get();
        $companies=Company::all();
        $projects=Project::all();

        return view('payment.create',['users'=>$users, 'companies'=>$companies ,'projects'=>$projects]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $demand_amount=$request->demand_amount;
        $paid_amount=$request->paid_amount;

        $payment=new Payment();

        $payment->user_id=$request->user_id;
        $payment->comments=$request->comments;
        $payment->total_demand_amount=array_sum($demand_amount);
        $payment->total_paid_amount=array_sum($paid_amount);
        $payment->created_by=$user->id;
        $payment->save();
        $projects=$request->project_id;

        foreach ($projects as $key=>$project){
            $paymentDetails = new Payment_details();
            $paymentDetails->project_id=$project;
            $paymentDetails->demand_amount=$demand_amount[$key];
            $paymentDetails->paid_amount=$paid_amount[$key];
            $payment->Payment_details()->save($paymentDetails);
        }
             $this->GeneratePaymentId($payment);
       // $acc->approval='Approved';
        return redirect()->route('payment')->with('success', 'Post has been successfully submitted pending for approval');

    }

    private function GeneratePaymentId(Payment $payment){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($payment->id,4, '0', STR_PAD_LEFT));

        $payment->payment_id=$sequentialId;
        $payment->save();
    }



    public function printPDF($id){

        $user=Payment::find($id);
        $pdf = PDF::loadView('payment.pdf_view', compact('user',$id));
        return $pdf->download('payment.pdf');

    }

    public function edite($id){

        //$payment = \DB::table('payments')->where('id', $id)->first();
        $payment=Payment::find($id);
        $companies=Company::all();
        $user=User::all();
        $project=Project::all();

        return view('payment.edite',['payment'=>$payment ,'companies'=>$companies ,'users'=>$user,'project'=>$project]);

    }


    public function update(Request $request,$id){

        $payment=Payment::find($id);
        $user = auth()->user();
        $demand_amount=$request->demand_amount;
        $paid_amount=$request->paid_amount;
      //  $payment=new Payment();
        $payment->user_id=$request->user_id;
        $payment->comments=$request->comments;
        $payment->total_demand_amount=array_sum($demand_amount);
        $payment->total_paid_amount=array_sum($paid_amount);
        $payment->created_by=$user->id;
        $payment->save();
        $projects=$request->project_id;

        foreach ($projects as $key=>$project){
            $paymentDetails = new Payment_details();
            $paymentDetails->project_id=$project;
            $paymentDetails->demand_amount=$demand_amount[$key];
            $paymentDetails->paid_amount=$paid_amount[$key];
            $payment->Payment_details()->save($paymentDetails);
        }


        return redirect()->route('payment');
    }






    public function approved($id){

        $payment=Payment::find($id);
        $payment->status=2;
        //$payment->status=2;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

    public function danger($id){
        $payment=Payment::find($id);
        //$payment->status=1;
        $payment->status=3;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>100]);
    }


//    public function details($id){
//
//        $payment=Payment::find($id);
//        $amendment = $payment->ammendment;
//        $total=$amendment->sum('additional_amount');
//        return view('payment.details',['payment'=>$payment, 'total'=>$total]);
//    }

       public function  Voucher($id){

       $payment=Payment::find($id);
       $amendment = $payment->ammendment;
       $total=$amendment->sum('additional_amount');
        return view('voucher.index',['payment'=>$payment, 'total'=>$total]);

    }


    public function delete($id){
        $payment=Payment::find($id);
        $payment->delete();
        return redirect()->route('payment');
    }



}
