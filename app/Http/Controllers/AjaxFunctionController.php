<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 6/25/20
 * Time: 3:50 PM
 */

namespace App\Http\Controllers;


use App\BankAndBranch;
use App\ExpenditureSector;
use App\Project;
use App\VoucherItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $expenditureSectors = ExpenditureSector::all();
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

}