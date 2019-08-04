<?php

namespace App\Http\Controllers;

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

        $payments=Payment::all();

        return view('payment.payment_index',['payments'=>$payments]);
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
            'demand_amount'=> 'digits_between:2,8',
            'payment_amount'=>'digits_between:2,8',

        ]);


        $acc=new Payment();

        $acc->d_amount=$request->demand_amount;
        $acc->due=$request->payment_amount;
        $acc->user_id=$request->user_id;
        $acc->company_id=$request->company_id;
        $acc->project_id=$request->project_id;
        $acc->comments=$request->comments;

        $acc->approval='Approved';


        $acc->save();
        return redirect()->route('payment');

    }

    public function printPDF($id){


        $user=Payment::find($id);

        $pdf = PDF::loadView('payment.pdf_view', compact('user',$id));

        return $pdf->download('payment.pdf');

    }


    public function edite($id){

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

        $payment->approval='Approved';

        $payment->save();
        return redirect()->route('payment');


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
