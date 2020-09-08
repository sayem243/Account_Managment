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

class LoanController extends Controller
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

        return view('loan_income.loan.index_loan',['companies'=>$arrayCompanies ]);
    }

    public function checkLoanStore(Request $request){

        if ($request->loan_from!='COMPANY'&& $request->loan_to!='COMPANY'){
            return redirect()->route('loan_income_create')->with('error','Error! Ops somethings wrong.');
        }

        if ($request->loan_from=='COMPANY'){
            $this->validate($request, [
                'check_number' => ['required'],
                'check_date' => ['required'],
                'check_amount' => ['required'],
                'loan_from_value_company' => ['required'],
                'loan_from_bank_id' => ['required'],
                'loan_from_branch_id' => ['required'],
                'loan_from_bank_account_id' => ['required'],
            ]);
        }elseif ($request->loan_to=='COMPANY'){
            $this->validate($request, [
                'check_number' => ['required'],
                'check_date' => ['required'],
                'check_amount' => ['required'],
                'loan_to_value_company' => ['required'],
                'loan_to_bank_id' => ['required'],
                'loan_to_branch_id' => ['required'],
                'loan_to_bank_account_id' => ['required'],
            ]);
        }else{
            $this->validate($request, [
                'check_number' => ['required'],
                'check_date' => ['required'],
                'check_amount' => ['required'],
            ]);
        }


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
        $loan->description = $request->check_description;
        $loan->save();

        if($loan->loan_from=='COMPANY'|| $loan->loan_from=='PROJECT'){
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
                'remarks'=>$request->check_description,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionFrom = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_from=$cashTransactionFrom;

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
            $checkRegistry->bank_id = $request->loan_from_bank_id?$request->loan_from_bank_id:null;
            $checkRegistry->branch_id = $request->loan_from_branch_id?$request->loan_from_branch_id:null;
            $checkRegistry->bank_account_id = $request->loan_from_bank_account_id?$request->loan_from_bank_account_id:null;
            $checkRegistry->created_by = auth()->id();
            $checkRegistry->description = $request->check_description;
            $checkRegistry->cash_transaction_id = $cashTransactionFrom;
            $checkRegistry->ref_type = 'LOAN';
            $checkRegistry->ref_id = $loan->id;
            $checkRegistry->save();


            $loan->check_registry_id_for_loan_from=$checkRegistry->id;
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


            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=>'LOAN_CHECK_'.$request->check_type,
                'transaction_via_ref_id'=>$loan->id,
                'amount'=>$loan->amount,
                'company_id'=>$companyId,
                'project_id'=>$projectId,
                'remarks'=>$request->check_description,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionTo = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_to=$cashTransactionTo;
            $loan->save();

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
            $checkRegistryIn->bank_id = $request->loan_to_bank_id?$request->loan_to_bank_id:null;
            $checkRegistryIn->branch_id = $request->loan_to_branch_id?$request->loan_to_branch_id:null;
            $checkRegistryIn->bank_account_id = $request->loan_to_bank_account_id?$request->loan_to_bank_account_id:null;
            $checkRegistryIn->created_by = auth()->id();
            $checkRegistryIn->description = $request->check_description;
            $checkRegistryIn->cash_transaction_id = $cashTransactionTo;
            $checkRegistry->ref_type = 'LOAN';
            $checkRegistry->ref_id = $loan->id;
            $checkRegistryIn->save();

            $loan->check_registry_id_for_loan_to=$checkRegistryIn->id;
            $loan->save();

        }

        $this->GenerateLoanId($loan);

        if($loan->id){
            return redirect()->route('loan_index')->with('success','Loan has been successfully created.');

        }

        return redirect()->route('loan_index')->with('error','Error! Ops somethings wrong.');


    }

    public function cashLoanStore(Request $request){

        if ($request->cash_loan_from!='COMPANY'&& $request->cash_loan_to!='COMPANY'){
            return redirect()->route('loan_income_create')->with('error','Error! Ops somethings wrong.');
        }
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
        $loan->description = $request->check_description;
        $loan->save();

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
                'remarks'=>$request->check_description,
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
                'remarks'=>$request->check_description,
                'created_by'=>$loan->created_by?$loan->created_by:null,
                'created_at'=>$loan->created_at?$loan->created_at:null,
            );
            $cashTransactionTo = CashTransaction::insertData($arrayData);

            $loan->cash_transaction_id_for_loan_to=$cashTransactionTo;
            $loan->save();

        }

        $this->GenerateLoanId($loan);

        if($loan->id){
            return redirect()->route('loan_index')->with('success','Loan has been successfully created.');

        }

        return redirect()->route('loan_index')->with('error','Error! Ops somethings wrong.');



    }

    public function loanDetailsView($id){

        $loan=Loan::find($id);

        return view('loan_income.loan.loan_view',['loan'=>$loan]);

    }

    public function loanQuickView($id){

        $loan=Loan::find($id);

        $returnHTML = view('loan_income.loan.loan_quick_view',['loan'=>$loan])->render();
        return response()->json( ['html'=>$returnHTML]);
    }

    public function loanPrint($id){
        $loan=Loan::find($id);
        if(auth()->user()->can('loan-income-create')) {
            return view('loan_income.loan.print', ['loan' => $loan]);
        }
        return redirect()->route('loan_index')->with('error', 'Error! This are not permitted.');

    }

    private function GenerateLoanId(Loan $loan){

        $firstJuly = new \DateTime(date("Y")."-07-01");

        $firstJuly = $firstJuly->format("Y-m-d");

        $datetime = new \DateTime("now");

        $currentDate = $datetime->format('Y-m_d');

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
//            $voucherId = $company->last_voucher_id;
            $voucherId = $company->last_voucher_id?$company->last_voucher_id:0;


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
        }else{
            $sequentialId = sprintf("%s%s%s",$loan->loan_to,$datetime->format('mY'), str_pad(00,4, '0', STR_PAD_LEFT));
            $loan->loan_generate_id=$sequentialId;
            $loan->save();
        }

    }

    public function dataTable(Request $request)
    {

        $countRecords = DB::table('loans');
        $countRecords->select('loans.id as totalLoan');

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

        $rows = DB::table('loans');
        $rows->select('loans.id as lId', 'loans.loan_generate_id as name', 'loans.amount as amount', 'loans.payment_mode as pMode', 'loans.loan_from as loanFrom', 'loans.loan_from_ref_id as loanFromRefId', 'loans.loan_to as loanTo', 'loans.loan_to_ref_id as loanToRefId', 'loans.created_at as loanDate');

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


            $button .='<li class="dropdown-item"><a href="/loan/details/'.$post->lId.'"><i class="feather icon-eye"></i>Details</a></li>';

            $button.='</ul></div>';

            $loanFrom = '';
            if($post->loanFrom=='USER'){
                $user = User::find($post->loanFromRefId);
                $loanFrom = $user->name;
            }elseif ($post->loanFrom=='COMPANY'){
                $company = Company::find($post->loanFromRefId);
                $loanFrom = $company->name;
            }elseif ($post->loanFrom=='PROJECT'){
                $project = Project::find($post->loanFromRefId);
                $loanFrom = $project->p_name;
            }elseif ($post->loanFrom=='OTHERS'){
                $loanFrom = $post->loanFromRefId;
            }
            $loanTo = '';
            if($post->loanTo=='USER'){
                $user = User::find($post->loanToRefId);
                $loanTo = $user->name;
            }elseif ($post->loanTo=='COMPANY'){
                $company = Company::find($post->loanToRefId);
                $loanTo = $company->name;
            }elseif ($post->loanTo=='PROJECT'){
                $project = Project::find($post->loanToRefId);
                $loanTo = $project->p_name;
            }elseif ($post->loanTo=='OTHERS'){
                $loanTo = $post->loanToRefId;
            }


            $records["data"][] = array(
                $id                 = $i,
                $name               = '<a data-toggle="modal" data-target-loan-id="'.$post->lId.'" data-target="#myModalLoan" href="javascript:void(0)">'.$post->name.'</a>',
                $loanDate          = date('d-m-Y',strtotime($post->loanDate)),
                $pMode          = $post->pMode,
                $loanFromRefId        = $loanFrom,
                $loanToRefId        = $loanTo,
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
