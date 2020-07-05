<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankAndBranch;
use App\Company;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index(){
        return view('bank_account.index');
    }

    public function create(){
        $companies= Company::all();
        $arrayCompanies=array();
        foreach ($companies as $company){
            $arrayCompanies[]=array('id'=>$company->id,'name'=>$company->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $arrayCompanies), SORT_ASC, $arrayCompanies);
        $banks= BankAndBranch::where('type', 'BANK')->get();
        return view('bank_account.add',['companies'=>$arrayCompanies ,'banks'=>$banks]);
    }

    public function store(Request $request){
        $this->validate($request, [

            'account_name' => ['required'],
            'account_number' => ['required'],
            'company_id' => ['required'],
            'bank_id' => ['required'],
            'branch_id' => ['required'],
        ]);

        $account = new BankAccount();
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->bank_id = $request->bank_id;
        $account->branch_id = $request->branch_id;
        $account->account_type = $request->account_type;
        $account->save();

        if($account->id){
            return redirect()->route('account_index')->with('success','Bank Account has been successfully created.');

        }

        return redirect()->route('account_index')->with('error','Error! Ops somethings wrong.');


    }

}
