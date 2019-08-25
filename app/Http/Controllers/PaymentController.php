<?php

namespace App\Http\Controllers;

use App\Ammendment;
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
    public function index(){

        $payments=Payment::orderBy('created_at','ASC')->paginate(6);

        $amendments=Ammendment::all();

        return view('payment.payment_index',['payments'=>$payments,'amendments'=>$amendments]);
    }

    public function create(){

       //$users=User::where('user_types_id',2)->get();
       $users=User::all();

       // $users=DB::users('user_types_id')->get();


        $companies=Company::all();
        $projects=Project::all();

        return view('payment.create',['users'=>$users, 'companies'=>$companies ,'projects'=>$projects  ]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'demand_amount'=> 'digits_between:2,10',
            'payment_amount'=>'digits_between:2,10',

        ]);


        $acc=new Payment();

        $acc->d_amount=$request->demand_amount;
        $acc->due=$request->payment_amount;
        $acc->user_id=$request->user_id;
        $acc->company_id=$request->company_id;
        $acc->project_id=$request->project_id;
        $acc->comments=$request->comments;

       // $acc->approval='Approved';


        $acc->save();
        return redirect()->route('payment')->with('success', 'Post has been successfully submitted pending for approval');


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

        return view('payment.edite',['payment'=>$payment ,'companies'=>$companies ,'users'=>$user ,'projects'=>$project ]);

    }


    public function update(Request $request,$id){

        $payment=Payment::find($id);

        $payment->d_amount=$request->demand_amount;
        $payment->due=$request->payment_amount;
        $payment->user_id=$request->user_id;
        $payment->company_id=$request->company_id;
        $payment->project_id=$request->project_id;



        $payment->save();
        return redirect()->route('payment');

    }

    public function approved($id){

        $payment=Payment::find($id);
        $payment->status=1;
        //$payment->status=2;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

    public function danger($id){
        $payment=Payment::find($id);
        //$payment->status=1;
        $payment->status=2;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>100]);
    }


    public function details($id){

        $payment=Payment::find($id);
        $amendment = $payment->ammendment;
        $total=$amendment->sum('additional_amount');
        return view('payment.details',['payment'=>$payment, 'total'=>$total]);
    }

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

    public function __construct()
    {
        $this->middleware('auth');
    }


}
