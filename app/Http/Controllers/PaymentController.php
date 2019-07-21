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


class PaymentController extends Controller
{
    public function index(){

        $payments=Payment::all();
        $companies=Company::all();
        //return view('payment.payment_index')->with('users',$user);
        return view('payment.payment_index',['payments'=>$payments]);
    }

    public function create(){

        $users=User::where('user_types_id',2)->get();


        $companies=Company::all();
        $projects=Project::all();

        return view('payment.create',['users'=>$users, 'companies'=>$companies ,'projects'=>$projects  ]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'Demand Ammount' => 'required|number',
            'Payment Ammount' => 'required|number',

        ]);


        $acc=new Payment();

        $acc->d_amount=$request->demand_amount;
        $acc->due=$request->payment_amount;
        $acc->user_id=$request->user_id;
        $acc->company_id=$request->company_id;
        $acc->project_id=$request->project_id;

        $acc->approval='Approved';


        $acc->save();
        return redirect()->route('payment');

    }

    public function printPDF($id){


        $user=Payment::find($id);




        $pdf = PDF::loadView('payment.pdf_view', compact('user',$id));
        return $pdf->download('payment.pdf');


    }






    public function __construct()
    {
        $this->middleware('auth');
    }


}
