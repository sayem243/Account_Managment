<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\CheckRegistry;
use App\Company;
use App\Income;
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

//    Loan section start

    public function checkLoanStore(Request $request){

//        var_dump($request);die;

        $this->validate($request, [
            'check_number' => ['required'],
            'check_date' => ['required'],
            'check_amount' => ['required'],
        ]);

        $loan = new Loan();
        $loan->payment_mode = "CHECK";
        $loan->amount = $request->check_amount;
        $loan->loan_from = $request->loan_from;

        $loan_from_ref_id='';
        if($request->loan_from=='USER'){
            $loan_from_ref_id = $request->loan_from_value_user;
        }elseif ($request->loan_from=='COMPANY'){
            $loan_from_ref_id = $request->loan_from_value_company;
        }elseif ($request->loan_from=='PROJECT'){
            $loan_from_ref_id = $request->loan_from_value_project;
        }elseif ($request->loan_from=='OTHERS'){
            $loan_from_ref_id = $request->loan_from_value_other;
        }

        $loan->loan_from_ref_id = $loan_from_ref_id;

        $loan->loan_to = $request->loan_to;
        $loan_to_ref_id='';
        if($request->loan_to=='USER'){
            $loan_to_ref_id = $request->loan_to_value_user;
        }elseif ($request->loan_to=='COMPANY'){
            $loan_to_ref_id = $request->loan_to_value_company;
        }elseif ($request->loan_to=='PROJECT'){
            $loan_to_ref_id = $request->loan_to_value_project;
        }elseif ($request->loan_to=='OTHERS'){
            $loan_to_ref_id = $request->loan_to_value_other;
        }
        $loan->loan_to_ref_id = $loan_to_ref_id;


        $loan->created_by = auth()->id();

        $loan->save();

        $this->GenerateLoanId($loan);

        if($loan->loan_from=='COMPANY'||$loan->loan_from=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_from=='COMPANY'){
                $companyId = $loan->loan_from_ref_id;
            }

            if($loan->loan_from=='PROJECT'){
                $project = Project::find($loan->loan_from_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_from_ref_id;
            }
            $checkRegistry = new CheckRegistry();
            $checkRegistry->check_mode = "OUT";
            $checkRegistry->check_type = $request->check_type?$request->check_type:'CASH';
            $checkRegistry->check_number = $request->check_number;
            $checkRegistry->check_date = $request->check_date;
            $checkRegistry->amount = $request->check_amount;
            $checkRegistry->from_to_type = $request->loan_to;
            $fromToValue='';
            if($request->loan_to=='USER'){
                $fromToValue = $request->loan_to_value_user;
            }elseif ($request->loan_to=='COMPANY'){
                $fromToValue = $request->loan_to_value_company;
            }elseif ($request->loan_to=='PROJECT'){
                $fromToValue = $request->loan_to_value_project;
            }elseif ($request->loan_to=='OTHERS'){
                $fromToValue = $request->loan_to_value_other;
            }
            $checkRegistry->from_to_value = $fromToValue;
            $checkRegistry->company_id = $companyId;
            $checkRegistry->project_id = $projectId;
            $checkRegistry->bank_id = $request->loan_from_bank_id;
            $checkRegistry->branch_id = $request->loan_from_branch_id;
            $checkRegistry->bank_account_id = $request->loan_from_bank_account_id;
            $checkRegistry->created_by = auth()->id();
            $checkRegistry->description = $request->check_description;
            $checkRegistry->save();


            $loan->check_registry_id_for_loan_from=$checkRegistry->id;
            $loan->save();
        }

        if( $loan->loan_from=='COMPANY'||$loan->loan_from=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_from=='COMPANY'){
                $companyId = $loan->loan_from_ref_id;
            }

            if($loan->loan_from=='PROJECT'){
                $project = Project::find($loan->loan_from_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_from_ref_id;
            }

            $arrayData= array(
                'transaction_type'=>'DR',
                'transaction_via'=>'LOAN_CHECK_'.$request->check_type,
                'transaction_via_ref_id'=>$loan->id,
                'amount'=>$loan->amount,
                'company_id'=>$companyId,
                'project_id'=>$projectId,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionFrom = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_from=$cashTransactionFrom;
            $loan->save();

        }


        if($loan->loan_to=='COMPANY'||$loan->loan_to=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_to=='COMPANY'){
                $companyId = $loan->loan_to_ref_id;
            }

            if($loan->loan_to=='PROJECT'){
                $project = Project::find($loan->loan_to_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_to_ref_id;
            }

            $checkRegistryIn = new CheckRegistry();
            $checkRegistryIn->check_mode = "IN";
            $checkRegistryIn->check_type = $request->check_type?$request->check_type:'CASH';
            $checkRegistryIn->check_number = $request->check_number;
            $checkRegistryIn->check_date = $request->check_date;
            $checkRegistryIn->amount = $request->check_amount;
            $checkRegistryIn->from_to_type = $request->loan_from;
            $fromToValue='';
            if($request->loan_from=='USER'){
                $fromToValue = $request->loan_from_value_user;
            }elseif ($request->loan_from=='COMPANY'){
                $fromToValue = $request->loan_from_value_company;
            }elseif ($request->loan_from=='PROJECT'){
                $fromToValue = $request->loan_from_value_project;
            }elseif ($request->loan_from=='OTHERS'){
                $fromToValue = $request->loan_from_value_other;
            }
            $checkRegistryIn->from_to_value = $fromToValue;
            $checkRegistryIn->company_id = $companyId;
            $checkRegistryIn->project_id = $projectId;
            $checkRegistryIn->bank_id = $request->loan_to_bank_id;
            $checkRegistryIn->branch_id = $request->loan_to_branch_id;
            $checkRegistryIn->bank_account_id = $request->loan_to_bank_account_id;
            $checkRegistryIn->created_by = auth()->id();
            $checkRegistryIn->description = $request->check_description;
            $checkRegistryIn->save();

            $loan->check_registry_id_for_loan_to=$checkRegistryIn->id;
            $loan->save();

        }

        if( $loan->loan_to=='COMPANY'||$loan->loan_to=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_to=='COMPANY'){
                $companyId = $loan->loan_to_ref_id;
            }

            if($loan->loan_to=='PROJECT'){
                $project = Project::find($loan->loan_to_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_to_ref_id;
            }

            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'LOAN_CHECK_'.$request->check_type,
                'transaction_via_ref_id'=>$loan->id,
                'amount'=>$loan->amount,
                'company_id'=>$companyId,
                'project_id'=>$projectId,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
           $cashTransactionTo = CashTransaction::insertData($arrayData);

           $loan->cash_transaction_id_for_loan_to=$cashTransactionTo;
           $loan->save();

        }

        if($loan->id){
            return redirect()->route('check_registry_index')->with('success','Loan has been successfully created.');

        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');


    }

    public function cashLoanStore(Request $request){
        $this->validate($request, [
            'cash_amount' => ['required'],
        ]);

        $loan = new Loan();
        $loan->payment_mode = "CASH";
        $loan->amount = $request->cash_amount;
        $loan->loan_from = $request->cash_loan_from;

        $loan_from_ref_id='';
        if($request->cash_loan_from=='USER'){
            $loan_from_ref_id = $request->loan_from_value_user;
        }elseif ($request->cash_loan_from=='COMPANY'){
            $loan_from_ref_id = $request->loan_from_value_company;
        }elseif ($request->cash_loan_from=='PROJECT'){
            $loan_from_ref_id = $request->loan_from_value_project;
        }elseif ($request->cash_loan_from=='OTHERS'){
            $loan_from_ref_id = $request->loan_from_value_other;
        }

        $loan->loan_from_ref_id = $loan_from_ref_id;

        $loan->loan_to = $request->cash_loan_to;
        $loan_to_ref_id='';
        if($request->cash_loan_to=='USER'){
            $loan_to_ref_id = $request->loan_to_value_user;
        }elseif ($request->cash_loan_to=='COMPANY'){
            $loan_to_ref_id = $request->loan_to_value_company;
        }elseif ($request->cash_loan_to=='PROJECT'){
            $loan_to_ref_id = $request->loan_to_value_project;
        }elseif ($request->cash_loan_to=='OTHERS'){
            $loan_to_ref_id = $request->loan_to_value_other;
        }
        $loan->loan_to_ref_id = $loan_to_ref_id;


        $loan->created_by = auth()->id();

        $loan->save();

        $this->GenerateLoanId($loan);

        if( $loan->loan_from=='COMPANY'||$loan->loan_from=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_from=='COMPANY'){
                $companyId = $loan->loan_from_ref_id;
            }

            if($loan->loan_from=='PROJECT'){
                $project = Project::find($loan->loan_from_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_from_ref_id;
            }

            $arrayData= array(
                'transaction_type'=>'DR',
                'transaction_via'=>'LOAN_CASH',
                'transaction_via_ref_id'=>$loan->id,
                'amount'=>$loan->amount,
                'company_id'=>$companyId,
                'project_id'=>$projectId,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionFrom = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_from=$cashTransactionFrom;
            $loan->save();

        }

        if( $loan->loan_to=='COMPANY'||$loan->loan_to=='PROJECT'){
            $companyId=null;
            $projectId=null;
            if($loan->loan_to=='COMPANY'){
                $companyId = $loan->loan_to_ref_id;
            }

            if($loan->loan_to=='PROJECT'){
                $project = Project::find($loan->loan_to_ref_id);
                $companyId = $project->company->id;
                $projectId = $loan->loan_to_ref_id;
            }

            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'LOAN_CASH',
                'transaction_via_ref_id'=>$loan->id,
                'amount'=>$loan->amount,
                'company_id'=>$companyId,
                'project_id'=>$projectId,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionTo = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_to=$cashTransactionTo;
            $loan->save();

        }

        if($loan->id){
            return redirect()->route('check_registry_index')->with('success','Loan has been successfully created.');

        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');



    }

    public function loanQuickView($id){

        $loan=Loan::find($id);

        $returnHTML = view('loan_income.loan_quick_view',['loan'=>$loan])->render();
        return response()->json( ['html'=>$returnHTML]);
    }

//    Loan section end

//    Income section start

    public function checkIncomeStore(Request $request){
        $this->validate($request, [
            'check_number' => ['required'],
            'check_date' => ['required'],
            'check_amount' => ['required'],
        ]);

        $income = new Income();
        $income->payment_mode = 'CHECK';
        $income->amount = $request->check_amount;

        $income->income_from = $request->income_from;

        $income_from_ref_id='';
        if($request->income_from=='USER'){
            $income_from_ref_id = $request->income_from_value_user;
        }elseif ($request->income_from=='COMPANY'){
            $income_from_ref_id = $request->income_from_value_company;
        }elseif ($request->income_from=='PROJECT'){
            $income_from_ref_id = $request->income_from_value_project;
        }elseif ($request->income_from=='OTHERS'){
            $income_from_ref_id = $request->income_from_value_other;
        }

        $income->income_from_ref_id = $income_from_ref_id;

        $income->company_id = isset($request->check_income_company_id)?$request->check_income_company_id:null;

        $income->created_by = auth()->id();
        $income->save();
        $this->GenerateIncomeId($income);

        if($income->id){
            $checkRegistry = new CheckRegistry();
            $checkRegistry->check_mode = "IN";
            $checkRegistry->check_type = $request->check_type?$request->check_type:'CASH';
            $checkRegistry->check_number = $request->check_number;
            $checkRegistry->check_date = $request->check_date;
            $checkRegistry->amount = $request->check_amount;
            $checkRegistry->from_to_type = $request->income_from;
            $fromToValue='';
            if($request->income_from=='USER'){
                $fromToValue = $request->income_from_value_user;
            }elseif ($request->income_from=='COMPANY'){
                $fromToValue = $request->income_from_value_company;
            }elseif ($request->income_from=='PROJECT'){
                $fromToValue = $request->income_from_value_project;
            }elseif ($request->income_from=='OTHERS'){
                $fromToValue = $request->income_from_value_other;
            }
            $checkRegistry->from_to_value = $fromToValue;

            $checkRegistry->company_id = $request->check_income_company_id;
            $checkRegistry->project_id = $request->project_id?$request->project_id:null;
            $checkRegistry->bank_id = $request->check_income_bank_id;
            $checkRegistry->branch_id = $request->check_income_branch_id;
            $checkRegistry->bank_account_id = $request->check_income_bank_account_id;
            $checkRegistry->created_by = auth()->id();
            $checkRegistry->description = $request->check_description;
            $checkRegistry->save();


            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'INCOME_CHECK_'.$request->check_type,
                'transaction_via_ref_id'=>$income->id,
                'amount'=>$checkRegistry->amount,
                'company_id'=>$checkRegistry->company_id,
                'project_id'=>$checkRegistry->project_id?$checkRegistry->project_id:null,
                'created_by'=>$checkRegistry->created_by?$checkRegistry->created_by:null,
                'created_at'=>$checkRegistry->created_at?$checkRegistry->created_at:null,
            );

            $cashTransaction = CashTransaction::insertData($arrayData);

            $income->cash_transaction_id=$cashTransaction;
            $income->check_registry_id=$checkRegistry->id;
            $income->save();
        }

        if($income->id){
            return redirect()->route('check_registry_index')->with('success','Income has been successfully entry.');
        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');

    }

    public function cashIncomeStore(Request $request){
        $this->validate($request, [
            'cash_amount' => ['required'],
        ]);

        $income = new Income();
        $income->payment_mode = 'CASH';
        $income->amount = $request->cash_amount;

        $income->income_from = $request->cash_income_from_to_type;

        $income_from_ref_id='';
        if($request->cash_income_from_to_type=='USER'){
            $income_from_ref_id = $request->from_to_value_user;
        }elseif ($request->cash_income_from_to_type=='COMPANY'){
            $income_from_ref_id = $request->from_to_value_company;
        }elseif ($request->cash_income_from_to_type=='PROJECT'){
            $income_from_ref_id = $request->from_to_value_project;
        }elseif ($request->cash_income_from_to_type=='OTHERS'){
            $income_from_ref_id = $request->from_to_value_other;
        }

        $income->income_from_ref_id = $income_from_ref_id;

        $income->company_id = isset($request->cash_income_company_id)?$request->cash_income_company_id:null;

        $income->created_by = auth()->id();
        $income->save();

        $this->GenerateIncomeId($income);


        $arrayData= array(
            'transaction_type'=>'CR',
            'transaction_via'=>'INCOME_CASH',
            'transaction_via_ref_id'=>$income->id,
            'amount'=>$income->amount,
            'company_id'=>$income->company_id,
            'created_by'=>$income->created_by?$income->created_by:null,
            'created_at'=>$income->created_at?$income->created_at:null,
        );

        $cashTransaction = CashTransaction::insertData($arrayData);

        $income->cash_transaction_id=$cashTransaction;

        $income->save();

        if($income->id){
            return redirect()->route('check_registry_index')->with('success','Income has been successfully entry.');
        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');

    }


    public function incomeQuickView($id){

        $income=Income::find($id);

        $returnHTML = view('loan_income.income_quick_view',['income'=>$income])->render();
        return response()->json( ['html'=>$returnHTML]);
    }



    private function GenerateLoanId(Loan $loan){

        if( $loan->loan_to=='COMPANY'||$loan->loan_to=='PROJECT'){
            $companyId=null;
            if($loan->loan_to=='COMPANY'){
                $companyId = $loan->loan_to_ref_id;
            }

            if($loan->loan_to=='PROJECT'){
                $project = Project::find($loan->loan_to_ref_id);
                $companyId = $project->company->id;
            }

            $company= Company::find($companyId);
            $companyCode = $company->code;
            $voucherId = $company->last_voucher_id;

            $firstJuly = new \DateTime(date("Y")."-07-01");

            $firstJuly = $firstJuly->format("Y-m-d");

            $datetime = new \DateTime("now");

            $currentDate = $datetime->format('Y-m_d');

            if($firstJuly==$currentDate){
                $voucherId = 1;
            }else{
                $voucherId= $voucherId+1;
            }

            $sequentialId = sprintf("%s%s%s",$companyCode,$datetime->format('mY'), str_pad($voucherId,4, '0', STR_PAD_LEFT));
            $loan->loan_generate_id=$sequentialId;
            $loan->save();

            $company = Company::find($company->id);
            $company->last_voucher_id=$voucherId;
            $company->save();
        }

    }

    private function GenerateIncomeId(Income $income){


            $company= Company::find($income->company_id);
            $companyCode = $company->code;
            $voucherId = $company->last_voucher_id;

            $firstJuly = new \DateTime(date("Y")."-07-01");

            $firstJuly = $firstJuly->format("Y-m-d");

            $datetime = new \DateTime("now");

            $currentDate = $datetime->format('Y-m_d');

            if($firstJuly==$currentDate){
                $voucherId = 1;
            }else{
                $voucherId= $voucherId+1;
            }

            $sequentialId = sprintf("%s%s%s",$companyCode,$datetime->format('mY'), str_pad($voucherId,4, '0', STR_PAD_LEFT));
            $income->income_generate_id=$sequentialId;
            $income->save();

            $company = Company::find($company->id);
            $company->last_voucher_id=$voucherId;
            $company->save();

    }

}
