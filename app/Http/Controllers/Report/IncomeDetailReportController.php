<?php
namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: mirfahim
 * Date: 10/4/20
 * Time: 12:13 PM
 */
class IncomeDetailReportController extends Controller
{
    public function incomeReport(){
        $user = auth()->user();
        $projects=$user->projects;
        $pUser= array();
        foreach ($projects as $project){
            foreach ($project->users as $user){
                $pUser[$user->id]= array('id'=>$user->id,'name'=>$user->name);
            }
        }
        $users=$pUser;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= array('id'=>$project->company->id,'name'=>$project->company->name);
        }
        $companies=$userProjectCompany;

        return view('reports.income_report',['users'=>$users,'companies'=>$companies,'projects'=>$projects]);
    }

    public function incomeReportDataTable(Request $request)
    {
        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company->id;
        }
        $query = $request->request->all();
        $countRecords = DB::table('incomes');
        $countRecords->select('incomes.id as totalIncome');
        $countRecords->leftJoin('income_details', 'income_details.income_id', '=', 'incomes.id');
//        $countRecords->join('companies', 'incomes.company_id', '=', 'companies.id');

        if (isset($query['income_generate_id'])) {
            $name = $query['income_generate_id'];
            $countRecords->where('incomes.income_generate_id', 'like', "{$name}%");
        }
        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('incomes.company_id',$company_id);
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('incomes.project_id',$project_id);
        }

        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $countRecords->whereBetween('incomes.created_at', [$from_date, $to_date]);
        }
        if(!$user->can('superadmin')||!$user->hasRole('Admin')){
            $countRecords->whereIn('incomes.company_id', $userProjectCompany);
        }

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
//        $rows->addSelect('companies.name as companyName');
        $rows->leftJoin('income_details', 'income_details.income_id', '=', 'incomes.id');
        $rows->join('companies', 'incomes.company_id', '=', 'companies.id');
        $rows->select('incomes.id as iId','incomes.income_generate_id as name', 'incomes.payment_mode as pMode',
            'incomes.income_from as incomeFrom', 'incomes.income_from_ref_id as incomeFromRefId', 'incomes.created_at as incomeDate',
            'incomes.created_at as incomeDateForSort');

        $rows->addSelect('income_details.bill_invoice_number as billInvoiceNumber', 'income_details.bill_invoice_number as billInvoiceNum',
            'income_details.bill_amount as billAmount','income_details.check_amount as amount',
            'income_details.certifite_amount as certifiteAmount','income_details.sd_amount as sdAmount',
            'income_details.it_amount as itAmount','income_details.vat_amount as vatAmount',
            'income_details.others_amount as otherAmount','income_details.check_referance as checkReferance');

//        $rows->addSelect('companies.name as companyName');
//        $rows->where('check_registries.status','!=', 0);
        if (isset($query['income_generate_id'])) {
            $name = $query['income_generate_id'];
            $rows->where('incomes.income_generate_id', 'like', "{$name}%");
        }
        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('incomes.company_id',$company_id);
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('incomes.project_id',$project_id);
        }

        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $rows->whereBetween('incomes.created_at', [$from_date, $to_date]);
        }
        if(!$user->can('superadmin')||!$user->hasRole('Admin')){
            $rows->whereIn('incomes.company_id', $userProjectCompany);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;



        foreach ($result as $post):

            $records["data"][] = array(
                $id                  = $i,
                $incomeDate          = isset($post->incomeDate)?date('d-m-Y',strtotime($post->incomeDate)):'',
                $billInvoiceNumber   = $post->billInvoiceNumber,

//                $companyName         = $post->companyName,
                $incomeDateForSort   = $post->incomeDateForSort,
                $billAmount          = isset($post->billAmount)?number_format($post->billAmount,2,'.',','):0.00,
                $certifiteAmount     = isset($post->certifiteAmount)?number_format($post->certifiteAmount,2,'.',','):0.00,
                $sdAmount            = isset($post->sdAmount)?number_format($post->sdAmount,2,'.',','):0.00,
                $itAmount            = isset($post->itAmount)?number_format($post->itAmount,2,'.',','):0.00,
                $vatAmount           = isset($post->vatAmount)?number_format($post->vatAmount,2,'.',','):0.00,
                $otherAmount         = isset($post->otherAmount)?number_format($post->otherAmount,2,'.',','):0.00,
                $amount              = isset($post->amount)?number_format($post->amount,2,'.',','):0.00,
                $checkReferance      = $post->checkReferance,
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