<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankAndBranch;
use App\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $account->company_id = $request->company_id;
        $account->bank_id = $request->bank_id;
        $account->branch_id = $request->branch_id;
        $account->account_type = $request->account_type;
        $account->save();

        if($account->id){
            return redirect()->route('account_index')->with('success','Bank Account has been successfully created.');

        }

        return redirect()->route('account_index')->with('error','Error! Ops somethings wrong.');


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


    public function dataTableAccount(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('bank_accounts');
        $countRecords->select('bank_accounts.id as totalBank');
        $countRecords->join('companies', 'bank_accounts.company_id', '=', 'companies.id');
        $countRecords->join('bank_and_branches as bank', 'bank_accounts.bank_id', '=', 'bank.id');
        $countRecords->join('bank_and_branches as branch', 'bank_accounts.branch_id', '=', 'branch.id');


        $result = $countRecords->get();
        $tcount = count($result);
        $iTotalRecords = $tcount;
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

        $rows = DB::table('bank_accounts');
        $rows->join('companies', 'bank_accounts.company_id', '=', 'companies.id');
        $rows->join('bank_and_branches as bank', 'bank_accounts.bank_id', '=', 'bank.id');
        $rows->join('bank_and_branches as branch', 'bank_accounts.branch_id', '=', 'branch.id');

        $rows->select('bank_accounts.id as baId','bank_accounts.account_name as name','bank_accounts.account_number as accountNumber','bank_accounts.deleted_at as accountDeletedAt');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('bank.name as bankName');
        $rows->addSelect('branch.name as branchName');

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if (auth()->user()->can('superadmin')) {
                if ($post->accountDeletedAt==null){
                    $button .= '<li class="dropdown-item"><a href="/account/edit/' . $post->baId . '"><i class="feather icon-eye"></i>Edit</a></li>';
                    $button .= '<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/account/delete/' . $post->baId . '" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
                }else{
                    $button .= '<li class="dropdown-item"><a href="/account/restore/' . $post->baId . '">
                                           <i class="fa fa-undo" aria-hidden="true"></i>
                                           Restore</a>
                                   </li>';
                }
            }
            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $name               = $post->name,
                $accountNumber             = $post->accountNumber,
                $company            = $post->companyName,
                $bank               = $post->bankName,
                $branch             = $post->branchName,
                $button,
                $status               = $post->accountDeletedAt,
            );
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
