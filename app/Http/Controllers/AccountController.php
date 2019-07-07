<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{

    public function index(){


        $accounts=Account::all();
        return view('home')->with('accounts',$accounts);
    }


    public function create(){
        return view('create');
    }

    public function edit($id){

        $ac = Account::find($id);
        return view('edit')->with('user',$ac);
    }


    public function store(Request $request)
    {
//        check validation

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',

        ]);


        $acc=new Account;

        $acc->name=$request->name;
        $acc->email=$request->email;
        $acc->mobile=$request->mobile;


        $acc->save();
        return redirect()->route('index');





    }


    public function update(Request $request,$id)
    {


        $acc=Account::find($id);

        $acc->name=$request->name;
        $acc->email=$request->email;
        $acc->mobile=$request->mobile;
        $acc->c_name=$request->c_name;

        $acc->save();
        return redirect()->route('index');



    }


    public function delete($id){

        $acc=Account::find($id);
        $acc->delete();



    }

}
