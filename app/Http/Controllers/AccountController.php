<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{

    public function index(){


        $accounts=Account::all();
        return view('main')->with('accounts',$accounts);
    }


    public function create(){
        $companies=Company::all();
        return view('create')->with('companies',$companies);
    }

    public function edit($id){

        $ac = Account::find($id);
        $companies=Company::all();
        return view('edit',['user'=>$ac, 'companies'=>$companies]);

    }


    public function store(Request $request)
    {
//        check validation

        $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',

        ]);


        $acc=new Account;

        $acc->name=$request->name;
        $acc->email=$request->email;
        $acc->mobile=$request->mobile;
        $acc->company_id=$request->company_id;


        $acc->save();
        return redirect()->route('index');



    }

    public function update(Request $request,$id)
    {

        $acc=Account::find($id);

        $acc->name=$request->name;
        $acc->email=$request->email;
        $acc->mobile=$request->mobile;
        $acc->company_id=$request->company_id;

        $acc->save();
        return redirect()->route('index');



    }


    public function delete($id){

        $acc=Account::find($id);
        $acc->delete();

    }


    public function __construct()
    {
        $this->middleware('auth');
    }



}
