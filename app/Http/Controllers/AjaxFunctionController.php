<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 6/25/20
 * Time: 3:50 PM
 */

namespace App\Http\Controllers;


use App\BankAndBranch;
use App\CustomClass\NumberToWordConverter;
use App\ExpenditureSector;
use App\Project;
use App\VoucherItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxFunctionController
{
    public function getProjectsByCompany($companyId){
        $data=array();
        if ($companyId==0){
            $user = auth()->user();
            $projects=$user->projects;
            foreach ($projects as $project){
                $data[]= array('id'=>$project->id,'name'=>$project->p_name);
            }
            array_multisort(array_map(function($element) {
                return $element['name'];
            }, $data), SORT_ASC, $data);

            return new JsonResponse($data);
        }
        $projects = Project::withTrashed()->where('company_id', $companyId)->get();

        if($projects){
            foreach ($projects as $project){
                $data[]=array(
                    'id'=>$project->id,
                    'name'=>$project->p_name,
                );
            }
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $data), SORT_ASC, $data);

        return new JsonResponse($data);
    }

    public function getUsersByProject($projectId){
        $data=array();
        if ($projectId==0){
            $user = auth()->user();
            $projects=$user->projects;
            foreach ($projects as $project){
                foreach ($project->users as $user){
                    $data[$user->id]= array('id'=>$user->id,'name'=>$user->name);
                }
            }
            array_multisort(array_map(function($element) {
                return $element['name'];
            }, $data), SORT_ASC, $data);

            return new JsonResponse($data);
        }
        $project= Project::withTrashed()->find($projectId);
        foreach ($project->users as $user){
            $data[$user->id]= array('id'=>$user->id,'name'=>$user->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $data), SORT_ASC, $data);

        return new JsonResponse($data);
    }

    public function addVoucherItem(Request $request){
        $data= array();
        $query = $request->request->all();
        if($query['item_name']!='' && $query['project_id']!='' && $query['voucher_amount']!=''){
            $expenditureSectors = ExpenditureSector::all()->sortBy('name');
            $expArray= array();
            foreach ($expenditureSectors as $expenditureSector){
                $expArray[]= array('id'=>$expenditureSector->id, 'name'=>$expenditureSector->name);
            }
            $voucherItem = new VoucherItems();

            $voucherItem->item_name = $query['item_name'];
            $voucherItem->payment_amount = $query['voucher_amount'];
            $voucherItem->voucher_amount = $query['voucher_amount'];
            $voucherItem->project_id = $query['project_id'];

            $voucherItem->save();

            if(isset($query['item_add_without_ajax']) && $query['item_add_without_ajax']==1){
                return redirect()->route('loan_income_create')->with('success', 'Voucher item has been created');

            }

            if($voucherItem){
                $data=array(
                    'expenditure_sector'=>$expArray,
                    'expenditure_sector_id'=>$query['expenditure_sector_id'],
                    'voucher_item_id'=>$voucherItem->id,
                    'item_name'=>$voucherItem->item_name,
                    'voucher_amount'=>$voucherItem->voucher_amount,
                    'project_id'=>$voucherItem->project_id,
                    'project_name'=>$voucherItem->project->p_name,
                );
            }
        }
        return new JsonResponse($data);
    }

    public function getBranchByBank($id){

        $bank = BankAndBranch::find($id);

        $branches = $bank->branches;
        $arrayData = array();
        foreach ($branches as $branch){
            $arrayData[]=array('id'=>$branch->id, 'name'=>$branch->name);
        }
        return new JsonResponse($arrayData);

    }

    public function getBanksByCompany($id){

        $rows = DB::table('bank_and_branches');
        $rows->join('bank_accounts', 'bank_and_branches.id', '=', 'bank_accounts.bank_id');
        $rows->join('companies', 'bank_accounts.company_id', '=', 'companies.id');
        $rows->select('bank_and_branches.id as bId', 'bank_and_branches.name as bName');
        $rows->where('bank_and_branches.type','=', 'BANK');
        $rows->where('companies.id','=', $id);
        $rows->orderBy('bank_and_branches.name', 'ASC');
        $rows->groupBy('bank_and_branches.id');
        $banks = $rows->get();
        $arrayData = array();
        foreach ($banks as $bank){
            $arrayData[]=array('id'=>$bank->bId, 'name'=>$bank->bName);
        }
        return new JsonResponse($arrayData);
    }

    public function getBranchesByCompanyBank($companyId, $bankId){

        $rows = DB::table('bank_and_branches');
        $rows->join('bank_accounts', 'bank_and_branches.id', '=', 'bank_accounts.branch_id');
        $rows->join('companies', 'bank_accounts.company_id', '=', 'companies.id');
        $rows->select('bank_and_branches.id as bId', 'bank_and_branches.name as bName');
        $rows->where('bank_and_branches.type','=', 'BRANCH');
        $rows->where('companies.id','=', $companyId);
        $rows->where('bank_accounts.bank_id','=', $bankId);
        $rows->orderBy('bank_and_branches.name', 'ASC');
        $branches = $rows->get();
        $arrayData = array();
        foreach ($branches as $branch){
            $arrayData[$branch->bId]=array('id'=>$branch->bId, 'name'=>$branch->bName);
        }
        return new JsonResponse($arrayData);
    }

    public function getAccountsByCompanyBankBranch($companyId, $bankId, $branchId){

        $rows = DB::table('bank_accounts');
        $rows->select('bank_accounts.id as aId', 'bank_accounts.account_number as aNumber');
        $rows->where('bank_accounts.company_id','=', $companyId);
        $rows->where('bank_accounts.bank_id','=', $bankId);
        $rows->where('bank_accounts.branch_id','=', $branchId);
        $rows->orderBy('bank_accounts.account_number', 'ASC');
        $banks = $rows->get();
        $arrayData = array();
        foreach ($banks as $bank){
            $arrayData[]=array('id'=>$bank->aId, 'name'=>$bank->aNumber);
        }
        return new JsonResponse($arrayData);
    }
//    for Ajax
    public function numberToWordConvert($number){

        $amount = NumberToWordConverter::convert($number);

        return new JsonResponse(array('amount'=>$amount));

    }

}