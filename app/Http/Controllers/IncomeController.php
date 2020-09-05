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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
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

    public function index(){
        $companies= Company::all();
        $arrayCompanies=array();
        foreach ($companies as $company){
            $arrayCompanies[]=array('id'=>$company->id,'name'=>$company->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $arrayCompanies), SORT_ASC, $arrayCompanies);

        return view('loan_income.index_income',['companies'=>$arrayCompanies ]);
    }


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
        $income->description = $request->check_description;
        $income->save();
        $this->GenerateIncomeId($income);

        if($income->id){
            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'INCOME_CHECK_'.$request->check_type,
                'transaction_via_ref_id'=>$income->id,
                'amount'=>$request->check_amount,
                'company_id'=>$request->check_income_company_id,
                'project_id'=>$request->project_id?$request->project_id:null,
                'remarks'=>$request->check_description,
                'created_by'=>auth()->id(),
                'created_at'=>$income->created_at?$income->created_at:null,
            );

            $cashTransaction = CashTransaction::insertData($arrayData);


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
            $checkRegistry->bank_id = $request->check_income_bank_id?$request->check_income_bank_id:null;
            $checkRegistry->branch_id = $request->check_income_branch_id?$request->check_income_branch_id:null;
            $checkRegistry->bank_account_id = $request->check_income_bank_account_id?$request->check_income_bank_account_id:null;
            $checkRegistry->created_by = auth()->id();
            $checkRegistry->description = $request->check_description;
            $checkRegistry->cash_transaction_id = $cashTransaction;
            $checkRegistry->save();


            $income->cash_transaction_id=$cashTransaction;
            $income->check_registry_id=$checkRegistry->id;
            $income->save();
        }

        if($income->id){
            return redirect()->route('income_index')->with('success','Income has been successfully entry.');
        }

        return redirect()->route('income_index')->with('error','Error! Ops somethings wrong.');

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
        $income->description = $request->check_description;
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
            return redirect()->route('income_index')->with('success','Income has been successfully entry.');
        }

        return redirect()->route('income_index')->with('error','Error! Ops somethings wrong.');

    }

    public function incomeDetailsView($id){

        $income=Income::find($id);

        return view('loan_income.income.income_view',['income'=>$income]);
    }

    public function incomePrint($id){
        $income=Income::find($id);
        if(auth()->user()->can('loan-income-create')) {
            return view('loan_income.income.print', ['income' => $income]);
        }
        return redirect()->route('loan_index')->with('error', 'Error! This are not permitted.');

    }

    public function incomeQuickView($id){

        $income=Income::find($id);

        $returnHTML = view('loan_income.income_quick_view',['income'=>$income])->render();
        return response()->json( ['html'=>$returnHTML]);
    }

    private function GenerateIncomeId(Income $income){


            $company= Company::find($income->company_id);
            $companyCode = $company->code;
//            $voucherId = $company->last_voucher_id;
            $voucherId = $company->last_voucher_id?$company->last_voucher_id:0;

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

    public function dataTable(Request $request)
    {

        $countRecords = DB::table('incomes');
        $countRecords->select('incomes.id as totalIncome');
        $countRecords->join('companies', 'incomes.company_id', '=', 'companies.id');

        $result = $countRecords->get();
        $tCount = count($result);
        $iTotalRecords = $tCount;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $records = array();
        $records["data"] = array();
        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['name']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

        $rows = DB::table('incomes');
        $rows->join('companies', 'incomes.company_id', '=', 'companies.id');
        $rows->select('incomes.id as iId', 'incomes.income_generate_id as name', 'incomes.amount as amount', 'incomes.payment_mode as pMode', 'incomes.income_from as incomeFrom', 'incomes.income_from_ref_id as incomeFromRefId', 'incomes.created_at as incomeDate');
        $rows->addSelect('companies.name as companyName');
//        $rows->where('check_registries.status','!=', 0);


        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';


            $button .='<li class="dropdown-item"><a href="/income/details/'.$post->iId.'"><i class="feather icon-eye"></i>Details</a></li>';

            $button.='</ul></div>';

            $incomeFrom = '';
            if($post->incomeFrom=='USER'){
                $user = User::find($post->incomeFromRefId);
                $incomeFrom = $user->name;
            }elseif ($post->incomeFrom=='COMPANY'){
                $company = Company::find($post->incomeFromRefId);
                $incomeFrom = $company->name;
            }elseif ($post->incomeFrom=='PROJECT'){
                $project = Project::find($post->incomeFromRefId);
                $incomeFrom = $project->p_name;
            }elseif ($post->incomeFrom=='OTHERS'){
                $incomeFrom = $post->incomeFromRefId;
            }


            $records["data"][] = array(
                $id                 = $i,
                $name               = '<a data-toggle="modal" data-target-income-id="'.$post->iId.'" data-target="#myModalIncome" href="javascript:void(0)">'.$post->name.'</a>',
                $incomeDate          = date('d-m-Y',strtotime($post->incomeDate)),
                $pMode          = $post->pMode,
                $companyName        = $post->companyName,
                $incomeFromRefId        = $incomeFrom,
                $amount             = $post->amount,

                $button);
            $i++;

        endforeach;
        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return new JsonResponse($records);
    }

}
