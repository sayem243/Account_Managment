<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Formatter\ScalarFormatter;


class ReportController extends Controller
{
    public function index(){

        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();
        $date=Payment_details::all();


        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
//            $detail[$detail->project->id][]= $detail->created_at;
        }

        return view('reports.index',['projects'=>$projects,'paymentDetails'=>$details ,'dates'=>$date]);
    }

//use for testing
    public function reportDate(){


        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();
        $date=Payment_details::all();
        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
        }

        return view('reports.try',['projects'=>$projects,'paymentDetails'=>$details ,'dates'=>$date]);
    }


    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $formDate = date('Y-m-d', strtotime($request->from_date));
                $toDate = date('Y-m-d', strtotime($request->to_date));
                $data = DB::table('payment_details')
                    ->whereBetween('created_at', array($formDate.' 00:00:00', $toDate.' 23:59:59'))
                    ->get();
            }
            else
            {
                $data = DB::table('payment_details')->orderBy('created_at', 'ASC')->get();
            }
            $paymentDetails=array();
            foreach ($data as $value){
                $paymentDetails[$value->project_id][]= $value->paid_amount;
            }
            $projects= Project::all();
            $html = '<tr>';
            foreach ($projects as $project){
                $html.='<td>';
                if(array_key_exists($project->id, $paymentDetails)){
                    $html.='<table class="table table-bordered payment_report">';
                    foreach($paymentDetails[$project->id] as $paymentDetail){
                        $html.='<tr><td>'.$paymentDetail.'</td></tr>';
                    }
                    $html.='</table>';
                }
                $html.='</td>';

            }
            $html.='</tr>';
            echo $html;

        }
    }

    public function paymentReport(){
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

        return view('reports.payment_report',['users'=>$users,'companies'=>$companies,'projects'=>$projects]);
    }

    public function dataTablePaymentReport(Request $request)
    {
        $query = $request->request->all();

        $countRecords = DB::table('payments');
        $countRecords->select('payments.id as totalPayment');
//        $countRecords->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
        $countRecords->join('projects', 'payments.project_id', '=', 'projects.id');
        $countRecords->join('users as employee', 'payments.user_id', '=', 'employee.id');
        $countRecords->join('users as createdBy', 'payments.created_by', '=', 'createdBy.id');
        $countRecords->join('companies', 'payments.company_id', '=', 'companies.id');

        $countRecords->where('payments.status','!=', 0);

        if (isset($query['payment_status'])) {
            $status = $query['payment_status'];
            if($status=='all'){
                $countRecords->where('payments.status','!=', 6);
            }else{
                $countRecords->where('payments.status','=', $status);
            }
        }

        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $countRecords->where('payments.payment_id', 'like', "{$name}%");
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('payments.company_id',$company_id);
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('payments.project_id',$project_id);
        }

        if (isset($query['user_id'])) {
            $user_id = $query['user_id'];
            $countRecords->where('payments.user_id', $user_id);
        }
        if(auth()->user()->can('employee') || auth()->user()->can('vendor')){
            $user= auth()->user();
            $countRecords->where('payments.user_id', $user->id);
        }else{
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $countRecords->whereIn('payments.project_id', $projectId);
        }

        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $countRecords->whereBetween('payments.created_at', [$from_date, $to_date]);
        }
//        $countRecords->groupBy('payment_details.payment_id');

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

        $rows = DB::table('payments');
//        $rows->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
        $rows->join('projects', 'payments.project_id', '=', 'projects.id');
        $rows->join('users as employee', 'payments.user_id', '=', 'employee.id');
        $rows->join('users as createdBy', 'payments.created_by', '=', 'createdBy.id');
        $rows->join('companies', 'payments.company_id', '=', 'companies.id');
        $rows->select('payments.id as pId', 'payments.payment_id as name', 'payments.total_paid_amount as amount', 'payments.status as pStatus', 'payments.created_at as created_at', 'payments.verified_at as paymentVerifyAt');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('companies.deleted_at as companyDeletedAt');
        $rows->addSelect('projects.deleted_at as projectDeletedAt');
        $rows->addSelect('employee.name as employeeName','employee.deleted_at as employeeDeletedAt');
        $rows->addSelect('createdBy.name as creatorName');
        $rows->where('payments.status','!=', 0);

        if (isset($query['payment_status'])) {
            $status = $query['payment_status'];
            if($status=='all'){
                $rows->where('payments.status','!=', 6);
            }else{
                $rows->where('payments.status','=', $status);
            }
        }

        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $rows->where('payments.payment_id', 'like', "{$name}%");
        }


        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('payments.company_id',$company_id);
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('payments.project_id',$project_id);
        }
        if (isset($query['user_id'])) {
            $user_id = $query['user_id'];
            $rows->where('payments.user_id', $user_id);
        }
        if(auth()->user()->can('employee') || auth()->user()->can('vendor')){
            $user= auth()->user();
            $rows->where('payments.user_id', $user->id);
        }else{
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $rows->whereIn('payments.project_id', $projectId);
        }
        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $rows->whereBetween('payments.created_at', [$from_date, $to_date]);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):
            $paymentStatus = '';
            if ($post->pStatus == 1 && $post->paymentVerifyAt == null) {
                $paymentStatus = '<span class="label label-yellow">Created (not verified)</span>';
            } elseif ($post->pStatus == 1 && $post->paymentVerifyAt != null) {
                $paymentStatus = '<span class="label label-yellow">Editing (needs re-verification)</span>';
            } elseif ($post->pStatus == 2) {
                $paymentStatus = '<span class="label label-orange">Verified (not approved)</span>';
            } elseif ($post->pStatus == 3) {
                $paymentStatus = '<span class="label label-green">Approved</span>';
            } elseif ($post->pStatus == 4) {
                $paymentStatus = '<span class="label label-blue">Disbursed</span>';
            } elseif ($post->pStatus == 5) {
                $paymentStatus = '<span class="label label-light-grey">Settled partial</span>';
            } elseif ($post->pStatus == 6) {
                $paymentStatus = '<span class="label label-grey">Archived</span>';
            }

            $records["data"][] = array(
                $id                 = $i,
                $createdAt          = date('d-m-Y',strtotime($post->created_at)),
                $name               = '<a data-toggle="modal" data-target-id="'.$post->pId.'" data-target="#myModal" href="javascript:void(0)">'.$post->name.'</a>',
                $employeeName       = $post->employeeName,
                $companyName        = $post->companyName?$post->companyName:'',
                $amount             = $post->amount,
//                $creatorName        = $post->creatorName,
                $pStatus            = $paymentStatus
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
