<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankAndBranch;
use App\CashTransaction;
use App\CheckRegistry;
use App\Company;
use App\Project;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckRegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:check-registry-create', ['only' => ['create','store']]);
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

        return view('check_registry.index',['companies'=>$arrayCompanies ]);
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

        $projects = Project::orderBy('p_name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();
        return view('check_registry.add',['companies'=>$arrayCompanies ,'projects'=>$projects, 'users'=>$users]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'check_number' => ['required'],
            'check_date' => ['required'],
            'bank_account_id' => ['required'],
            'company_id' => ['required'],
            'bank_id' => ['required'],
            'branch_id' => ['required'],
            'check_amount' => ['required'],
        ]);

        $checkRegistry = new CheckRegistry();
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

        if($checkRegistry->check_mode==='OUT'){
            $arrayData= array(
                'transaction_type'=>'CR',
                'transaction_via'=> $checkRegistry->check_type==='CASH'?'CHECK_OUT':'CHECK_OUT_ACCOUNT_PAY',
                'transaction_via_ref_id'=>$checkRegistry->id,
                'amount'=>$checkRegistry->amount,
                'company_id'=>$checkRegistry->company_id,
                'project_id'=>$checkRegistry->project_id?$checkRegistry->project_id:null,
                'created_by'=>$checkRegistry->created_by?$checkRegistry->created_by:null,
                'created_at'=>$checkRegistry->created_at?$checkRegistry->created_at:null,
                'remarks' => $request->check_description
            );
            CashTransaction::insertData($arrayData);

        }

        if($checkRegistry->id){
            return redirect()->route('check_registry_index')->with('success','Expense has been successfully entry.');

        }

        return redirect()->route('check_registry_index')->with('error','Error! Ops somethings wrong.');


    }

    public function edit($id){
        $account = BankAccount::find($id);
        $companies= Company::all();
        $arrayCompanies=array();
        foreach ($companies as $company){
            $arrayCompanies[]=array('id'=>$company->id,'name'=>$company->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $arrayCompanies), SORT_ASC, $arrayCompanies);
        $banks= BankAndBranch::where('type', 'BANK')->get();
        return view('bank_account.edit',['account'=>$account ,'companies'=>$arrayCompanies ,'banks'=>$banks]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [

            'account_name' => ['required'],
            'account_number' => ['required'],
            'company_id' => ['required'],
            'bank_id' => ['required'],
            'branch_id' => ['required'],
        ]);

        $account = BankAccount::find($id);
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->company_id = $request->company_id;
        $account->bank_id = $request->bank_id;
        $account->branch_id = $request->branch_id;
        $account->account_type = $request->account_type;
        $account->save();

        if($account->id){
            return redirect()->route('account_index')->with('success','Bank Account has been successfully Updated.');

        }

        return redirect()->route('account_index')->with('error','Error! Ops somethings wrong.');


    }

    public function details($id){

        $checkRegistry=CheckRegistry::find($id);
        return view('check_registry.view')->with('checkRegistry' ,$checkRegistry);
    }
    public function quickView($id){

        $checkRegistry=CheckRegistry::find($id);

        $returnHTML = view('check_registry.quick_view',['checkRegistry'=>$checkRegistry])->render();
        return response()->json( ['html'=>$returnHTML]);
    }

    public function deleteAccount($id){
        $account=BankAccount::find($id);
        $account->delete();
        return redirect()->route('account_index')->with('success','Bank Account has been successfully deleted.');
    }
    public function accountRestore($id){
        BankAccount::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('account_index')->with('success','Bank Account has been successfully restored.');
    }

    public function dataTable(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('check_registries');
        $countRecords->select('check_registries.id as totalCheckRegistry');
        $countRecords->join('companies', 'check_registries.company_id', '=', 'companies.id');

//        $countRecords->where('check_registries.status','!=', 0);

        if (isset($query['check_number'])) {
            $name = $query['check_number'];
            $countRecords->where('check_registries.check_number', 'like', "{$name}%");
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('check_registries.company_id',$company_id);
        }

        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $countRecords->whereBetween('check_registries.created_at', [$from_date, $to_date]);
        }
//        $countRecords->groupBy('payment_details.payment_id');

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

        $rows = DB::table('check_registries');
        $rows->join('companies', 'check_registries.company_id', '=', 'companies.id');
        $rows->select('check_registries.id as crId', 'check_registries.check_number as name', 'check_registries.amount as amount', 'check_registries.check_date as checkDate', 'check_registries.check_mode as checkMode', 'check_registries.check_type as checkType');
        $rows->addSelect('companies.name as companyName');

//        $rows->where('check_registries.status','!=', 0);


        if (isset($query['check_number'])) {
            $name = $query['check_number'];
            $rows->where('check_registries.check_number', 'like', "%{$name}%");
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('check_registries.company_id',$company_id);
        }

        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $rows->whereBetween('check_registries.created_at', [$from_date, $to_date]);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';


            $button .='<li class="dropdown-item"><a href="/check/registry/details/'.$post->crId.'"><i class="feather icon-eye"></i>Details</a></li>';

            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $name               = '<a data-toggle="modal" data-target-id="'.$post->crId.'" data-target="#myModal" href="javascript:void(0)">'.$post->name.'</a>',
                $checkDate          = date('d-m-Y',strtotime($post->checkDate)),
                $companyName        = $post->companyName?$post->companyName:'',
                $amount             = $post->amount,
                $checkType          = $post->checkType,
                $checkMode          = $post->checkMode=='IN'?'Credit':'Debit',

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
