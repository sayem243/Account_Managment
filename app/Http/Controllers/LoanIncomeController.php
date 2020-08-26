<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\Company;
use App\Loan;
use App\Payment;
use App\PaymentSettlement;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function createLoanAndIncome(){
        $companies= Company::all();
        $arrayCompanies=array();
        foreach ($companies as $company){
            $arrayCompanies[]=array('id'=>$company->id,'name'=>$company->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $arrayCompanies), SORT_ASC, $arrayCompanies);

        $projects = Project::orderBy('p_name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();
        return view('loan_income.add',['companies'=>$arrayCompanies ,'projects'=>$projects, 'users'=>$users]);
    }


    public function checkLoanStore(Request $request){
        $this->validate($request, [
            'check_number' => ['required'],
            'check_date' => ['required'],
            'check_amount' => ['required'],
        ]);

        $checkRegistry = new Loan();
        $checkRegistry->check_mode = $request->check_mode;
        $checkRegistry->check_type = $request->check_type?$request->check_type:'CASH';
        $checkRegistry->check_number = $request->check_number;
        $checkRegistry->check_date = $request->check_date;
        $checkRegistry->amount = $request->check_amount;
        $checkRegistry->from_to_type = $request->from_to_type;
        $fromToValue='';
        if($request->from_to_type=='USER'){
            $fromToValue = $request->from_to_value_user;
        }elseif ($request->from_to_type=='COMPANY'){
            $fromToValue = $request->from_to_value_company;
        }elseif ($request->from_to_type=='PROJECT'){
            $fromToValue = $request->from_to_value_project;
        }elseif ($request->from_to_type=='OTHERS'){
            $fromToValue = $request->from_to_value_other;
        }
        $checkRegistry->from_to_value = $fromToValue;
        $checkRegistry->company_id = $request->company_id;
        $checkRegistry->project_id = $request->project_id?$request->project_id:null;
        $checkRegistry->bank_id = $request->bank_id;
        $checkRegistry->branch_id = $request->branch_id;
        $checkRegistry->bank_account_id = $request->bank_account_id;
        $checkRegistry->created_by = auth()->id();
        $checkRegistry->description = $request->check_description;
        $checkRegistry->save();

        if($checkRegistry->check_mode==='OUT' && $checkRegistry->check_type==='CASH'){
            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'CHECK_OUT',
                'transaction_via_ref_id'=>$checkRegistry->id,
                'amount'=>$checkRegistry->amount,
                'company_id'=>$checkRegistry->company_id,
                'project_id'=>$checkRegistry->project_id?$checkRegistry->project_id:null,
                'created_by'=>$checkRegistry->created_by?$checkRegistry->created_by:null,
                'created_at'=>$checkRegistry->created_at?$checkRegistry->created_at:null,
            );
            CashTransaction::insertData($arrayData);

        }

        if($checkRegistry->id){
            return redirect()->route('check_registry_index')->with('success','Check registry has been successfully entry.');

        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');


    }
    public function checkIncomeStore(Request $request){
        $this->validate($request, [
            'check_number' => ['required'],
            'check_date' => ['required'],
            'check_amount' => ['required'],
        ]);

        $checkRegistry = new Loan();
        $checkRegistry->check_mode = $request->check_mode;
        $checkRegistry->check_type = $request->check_type?$request->check_type:'CASH';
        $checkRegistry->check_number = $request->check_number;
        $checkRegistry->check_date = $request->check_date;
        $checkRegistry->amount = $request->check_amount;
        $checkRegistry->from_to_type = $request->from_to_type;
        $fromToValue='';
        if($request->from_to_type=='USER'){
            $fromToValue = $request->from_to_value_user;
        }elseif ($request->from_to_type=='COMPANY'){
            $fromToValue = $request->from_to_value_company;
        }elseif ($request->from_to_type=='PROJECT'){
            $fromToValue = $request->from_to_value_project;
        }elseif ($request->from_to_type=='OTHERS'){
            $fromToValue = $request->from_to_value_other;
        }
        $checkRegistry->from_to_value = $fromToValue;
        $checkRegistry->company_id = $request->company_id;
        $checkRegistry->project_id = $request->project_id?$request->project_id:null;
        $checkRegistry->bank_id = $request->bank_id;
        $checkRegistry->branch_id = $request->branch_id;
        $checkRegistry->bank_account_id = $request->bank_account_id;
        $checkRegistry->created_by = auth()->id();
        $checkRegistry->description = $request->check_description;
        $checkRegistry->save();

        if($checkRegistry->check_mode==='OUT' && $checkRegistry->check_type==='CASH'){
            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'CHECK_OUT',
                'transaction_via_ref_id'=>$checkRegistry->id,
                'amount'=>$checkRegistry->amount,
                'company_id'=>$checkRegistry->company_id,
                'project_id'=>$checkRegistry->project_id?$checkRegistry->project_id:null,
                'created_by'=>$checkRegistry->created_by?$checkRegistry->created_by:null,
                'created_at'=>$checkRegistry->created_at?$checkRegistry->created_at:null,
            );
            CashTransaction::insertData($arrayData);

        }

        if($checkRegistry->id){
            return redirect()->route('check_registry_index')->with('success','Check registry has been successfully entry.');

        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');


    }

}
