<?php

namespace App\Http\Controllers;

use App\CashDailyBalanceSession;
use App\CashTransaction;
use App\CheckRegistry;
use App\Company;
use App\ExpenditureSector;
use App\Payment;
use App\Payment_details;
use App\Project;
use App\User;
use App\Vocher;
use App\Vocher_details;
use App\Voucher;
use App\VoucherItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class VoucherController extends Controller
{
    protected $dailyCashSession;
    protected $dailyCashTransaction;

    function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:Payment-create', ['only' => ['index','create','store','approve','verify']]);
        $this->middleware('permission:voucher_approved', ['only' => ['approved']]);
        $this->middleware('permission:voucher_create', ['only' => ['index','store','voucherPdf','voucherPrint','archivedList']]);
        $this->middleware('permission:superadmin', ['only' => ['delete']]);

        $this->dailyCashSession = new CashDailyBalanceSession();
        $this->dailyCashTransaction = new CashTransaction();

    }


    Public function index(Request $request){
        $user = auth()->user();
        $projects=$user->projects;

        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= array('id'=>$project->company->id,'name'=>$project->company->name);
        }

        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $userProjectCompany), SORT_ASC, $userProjectCompany);

        $companies=$userProjectCompany;

        $expenditureSectors = ExpenditureSector::all()->sortBy('name');
        return  view('voucher.index',['projects'=>$projects, 'expenditureSectors'=>$expenditureSectors, 'companies'=>$companies]);
    }

    Public function archivedList(Request $request){

        $auth_plain_pass= $request->session()->get('logged_in_user_password');
        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= array('id'=>$project->company->id,'name'=>$project->company->name);
        }

        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $userProjectCompany), SORT_ASC, $userProjectCompany);

        $companies=$userProjectCompany;
        $expenditureSectors = ExpenditureSector::all()->sortBy('name');
        return  view('voucher.archive',['auth_plain_pass'=>$auth_plain_pass, 'projects'=>$projects, 'companies'=>$companies,'expenditureSectors'=>$expenditureSectors]);
    }

    public function dataTable(Request $request)
    {
        $expenditureSectors = ExpenditureSector::all()->sortBy('name');

        $query = $request->request->all();

        $countRecords = DB::table('voucher_items');
        $countRecords->select('voucher_items.id as totalVoucherItems');
//        $countRecords->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
        $countRecords->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $countRecords->join('companies', 'projects.company_id', '=', 'companies.id');
        $countRecords->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');

        $countRecords->where('voucher_items.status','=', 0);
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $countRecords->where('payments.payment_id', 'like', "{$name}%");
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('voucher_items.project_id',$project_id);
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('companies.id',$company_id);
        }
        if(!auth()->user()->can('superadmin')||!auth()->user()->hasRole('Admin')){
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $countRecords->whereIn('voucher_items.project_id', $projectId);
        }

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

        $rows = DB::table('voucher_items');
//        $rows->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
//        $rows->join('projects', 'payment_details.project_id', '=', 'projects.id');
        $rows->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $rows->join('companies', 'projects.company_id', '=', 'companies.id');
        $rows->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');
        $rows->leftJoin('check_registries', 'voucher_items.check_registry_id', '=', 'check_registries.id');
        $rows->select('voucher_items.id as viId', 'voucher_items.item_name as name', 'voucher_items.voucher_amount as amount', 'voucher_items.created_at as createdDate');
        $rows->addSelect('projects.p_name as projectName','projects.id as projectId');
        $rows->addSelect('payments.payment_id as pId');
        $rows->addSelect('check_registries.id as crId','check_registries.check_number as checkNumber','check_registries.check_type as checkType');
        $rows->where('voucher_items.status','=', 0);
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $rows->where('payments.payment_id', 'like', "{$name}%");
        }
        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('voucher_items.project_id',$project_id);
        }
        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('companies.id',$company_id);
        }
        if(!auth()->user()->can('superadmin')||!auth()->user()->hasRole('Admin')){
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $rows->whereIn('voucher_items.project_id', $projectId);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);

        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;


        if(isset($query['voucher_type'])&&$query['voucher_type']=='cash_cheque'){

            foreach ($result as $post):
                if($post->checkType=='CASH'){
                $dropdown='<select name="expenditure_sector['.$post->viId.']" class="form-control select2">
                <option value="">Select Type</option>';
                foreach ($expenditureSectors as $expenditureSector){
                    $dropdown.= '<option value="'.$expenditureSector->id.'">'.$expenditureSector->name.'</option>';
                }

                $dropdown .='</select>';

                $checkbox = '<input type="checkbox" class="voucher_item" name="voucher_item[]" value="'.$post->viId.'">';
                $button = '<button type="button" data-id="'.$post->viId.'" class="btn btn-danger remove_row">X</button>';

                $records["data"][] = array(
                    $checkbox,
                    $dropdown,
                    $name               = '<input type="hidden" value="'.$post->name.'" name="item_name['.$post->viId.']">'.$post->name,
                    $createdDate          = $post->createdDate,
                    $pId                = $post->pId?$post->pId:$post->checkNumber.'<input type="hidden" value="'.$post->crId.'" name="check_id['.$post->viId.']">',
                    $projectName        = $post->projectName?'<input type="hidden" value="'.$post->projectId.'" name="project_id['.$post->viId.']">'.$post->projectName:'',
                    $amount             = '<input type="hidden" value="'.$post->amount.'" name="voucher_amount['.$post->viId.']">'.number_format($post->amount,2,'.',','),
                    $button,
                    $checkType               = $post->checkType
                );
                $i++;
                }
            endforeach;
        }elseif (isset($query['voucher_type'])&&$query['voucher_type']=='account_pay_cheque'){

            foreach ($result as $post):
                if($post->checkType=='ACCOUNT_PAY'){
                $dropdown='<select name="expenditure_sector['.$post->viId.']" class="form-control select2">
                <option value="">Select Type</option>';
                foreach ($expenditureSectors as $expenditureSector){
                    $dropdown.= '<option value="'.$expenditureSector->id.'">'.$expenditureSector->name.'</option>';
                }

                $dropdown .='</select>';

                $checkbox = '<input type="checkbox" class="voucher_item" name="voucher_item[]" value="'.$post->viId.'">';
                $button = '<button type="button" data-id="'.$post->viId.'" class="btn btn-danger remove_row">X</button>';

                $records["data"][] = array(
                    $checkbox,
                    $dropdown,
                    $name               = '<input type="hidden" value="'.$post->name.'" name="item_name['.$post->viId.']">'.$post->name,
                    $createdDate          = $post->createdDate,
                    $pId                = $post->pId?$post->pId:$post->checkNumber.'<input type="hidden" value="'.$post->crId.'" name="check_id['.$post->viId.']">',
                    $projectName        = $post->projectName?'<input type="hidden" value="'.$post->projectId.'" name="project_id['.$post->viId.']">'.$post->projectName:'',
                    $amount             = '<input type="hidden" value="'.$post->amount.'" name="voucher_amount['.$post->viId.']">'. number_format($post->amount,2,'.',','),
                    $button,
                    $checkType               = $post->checkType
                );
                $i++;
                }
            endforeach;
        }elseif (isset($query['voucher_type'])&&$query['voucher_type']=='account_transfer_cheque'){

            foreach ($result as $post):
                if($post->checkType=='ACCOUNT_TRANSFER'){
                $dropdown='<select name="expenditure_sector['.$post->viId.']" class="form-control select2">
                <option value="">Select Type</option>';
                foreach ($expenditureSectors as $expenditureSector){
                    $dropdown.= '<option value="'.$expenditureSector->id.'">'.$expenditureSector->name.'</option>';
                }

                $dropdown .='</select>';

                $checkbox = '<input type="checkbox" class="voucher_item" name="voucher_item[]" value="'.$post->viId.'">';
                $button = '<button type="button" data-id="'.$post->viId.'" class="btn btn-danger remove_row">X</button>';

                $records["data"][] = array(
                    $checkbox,
                    $dropdown,
                    $name               = '<input type="hidden" value="'.$post->name.'" name="item_name['.$post->viId.']">'.$post->name,
                    $createdDate          = $post->createdDate,
                    $pId                = $post->pId?$post->pId:$post->checkNumber.'<input type="hidden" value="'.$post->crId.'" name="check_id['.$post->viId.']">',
                    $projectName        = $post->projectName?'<input type="hidden" value="'.$post->projectId.'" name="project_id['.$post->viId.']">'.$post->projectName:'',
                    $amount             = '<input type="hidden" value="'.$post->amount.'" name="voucher_amount['.$post->viId.']">'. number_format($post->amount,2,'.',','),
                    $button,
                    $checkType               = $post->checkType
                );
                $i++;
                }
            endforeach;
        }else{
            foreach ($result as $post):
                if($post->checkType != 'CASH' && $post->checkType != 'ACCOUNT_PAY' && $post->checkType != 'ACCOUNT_TRANSFER') {
                    $dropdown = '<select name="expenditure_sector[' . $post->viId . ']" class="form-control select2">
                    <option value="">Select Type</option>';
                    foreach ($expenditureSectors as $expenditureSector) {
                        $dropdown .= '<option value="' . $expenditureSector->id . '">' . $expenditureSector->name . '</option>';
                    }

                    $dropdown .= '</select>';

                    $checkbox = '<input type="checkbox" class="voucher_item" name="voucher_item[]" value="' . $post->viId . '">';
                    $button = '<button type="button" data-id="' . $post->viId . '" class="btn btn-danger remove_row">X</button>';

                    $records["data"][] = array(
                        $checkbox,
                        $dropdown,
                        $name = '<input type="hidden" value="' . $post->name . '" name="item_name[' . $post->viId . ']">' . $post->name,
                        $createdDate          = $post->createdDate,
                        $pId = $post->pId ? $post->pId : $post->checkNumber . '<input type="hidden" value="' . $post->crId . '" name="check_id[' . $post->viId . ']">',
                        $projectName = $post->projectName ? '<input type="hidden" value="' . $post->projectId . '" name="project_id[' . $post->viId . ']">' . $post->projectName : '',
                        $amount = '<input type="hidden" value="' . $post->amount . '" name="voucher_amount[' . $post->viId . ']">' . number_format($post->amount,2,'.',','),
                        $button,
                        $checkType = $post->checkType
                    );
                    $i++;
                }
            endforeach;
        }


        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return new JsonResponse($records);
    }

    public function dataTableArchived(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('vouchers');
        $countRecords->select('vouchers.id as totalVouchers');
        $countRecords->join('expenditure_sectors', 'vouchers.expenditure_sector_id', '=', 'expenditure_sectors.id');
        $countRecords->join('voucher_items', 'vouchers.id', '=', 'voucher_items.voucher_id');
        $countRecords->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $countRecords->join('companies', 'projects.company_id', '=', 'companies.id');
        $countRecords->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');

        $countRecords->whereNull('vouchers.deleted_at');
        $countRecords->where('voucher_items.status','!=', 0);
        if (isset($query['voucher_id'])) {
            $name = $query['voucher_id'];
            $countRecords->where('vouchers.voucher_generate_id', 'like', "{$name}%");
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('voucher_items.project_id',$project_id);
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('companies.id',$company_id);
        }
        if(isset($query['expenditure_sector'])){
            $expenditure_sector = $query['expenditure_sector'];
            $countRecords->where('expenditure_sectors.id',$expenditure_sector);
        }
        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $countRecords->whereBetween('vouchers.created_at', [$from_date, $to_date]);
        }

        if (isset($query['voucher_status'])){
            $status = $query['voucher_status'];
            if($status=='all'){
                $countRecords->whereIn('vouchers.status',[1,2,3]);
            }else{
                $countRecords->where('vouchers.status','=', $status);
            }
        }

        if(!auth()->user()->can('superadmin')||!auth()->user()->hasRole('Admin')){
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $countRecords->whereIn('voucher_items.project_id', $projectId);
        }

        $countRecords->groupBy('totalVouchers');
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

        $rows = DB::table('vouchers');

        $rows->select('vouchers.id as id', 'vouchers.voucher_generate_id as vId', 'vouchers.total_amount as amount', 'vouchers.created_at as createdAt', 'vouchers.created_at as createdAtForSort', 'vouchers.status as vStatus');
        $rows->addSelect( 'voucher_items.item_name as name', 'voucher_items.voucher_id as voucherId');
        $rows->addSelect('projects.p_name as projectName');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('companies.deleted_at as companyDeletedAt');
        $rows->addSelect('projects.deleted_at as projectDeletedAt');
        $rows->addSelect('expenditure_sectors.name as expenseName');
        $rows->addSelect('payments.payment_id as pId');

        $rows->join('expenditure_sectors', 'vouchers.expenditure_sector_id', '=', 'expenditure_sectors.id');
        $rows->join('voucher_items', 'vouchers.id', '=', 'voucher_items.voucher_id');
        $rows->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $rows->join('companies', 'projects.company_id', '=', 'companies.id');
        $rows->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');

        $rows->whereNull('vouchers.deleted_at');
        $rows->where('voucher_items.status','!=', 0);

        if (isset($query['voucher_id'])) {
            $name = $query['voucher_id'];
            $rows->where('vouchers.voucher_generate_id', 'like', "{$name}%");
        }
        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('voucher_items.project_id',$project_id);
        }
        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('companies.id',$company_id);
        }
        if(isset($query['expenditure_sector'])){
            $expenditure_sector = $query['expenditure_sector'];
            $rows->where('expenditure_sectors.id',$expenditure_sector);
        }
        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $rows->whereBetween('vouchers.created_at', [$from_date, $to_date]);
        }

        if (isset($query['voucher_status'])){
            $status = $query['voucher_status'];
            if($status=='all'){
                $rows->whereIn('vouchers.status',[1,2,3]);
            }else{
                $rows->where('vouchers.status','=', $status);
            }
        }


        if(!auth()->user()->can('superadmin')||!auth()->user()->hasRole('Admin')){
            $projects= auth()->user()->projects;
            $projectId=array();
            foreach ($projects as $project){
                $projectId[]=$project->id;
            }
            $rows->whereIn('voucher_items.project_id', $projectId);
        }

        $rows->groupBy('voucherId');
        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;


        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';

            $button .='<li class="dropdown-item"><a href="/voucher/details/'.$post->id.'"><i class="feather icon-eye"></i>Details</a></li>';
            if (auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin')) {
                $button .= '<li class="dropdown-item"><a class="remove_voucher" href="javascript:void(0)" data-id="' . $post->id . '"><i class="feather icon-trash-2" ></i >Remove</a></li>';
            }
            $button.='</ul></div>';

            $action='';

            if ($post->companyDeletedAt==null && $post->projectDeletedAt==null){
                if($post->vStatus==1 && auth()->user()->can('voucher_approved')){
                    $action.='<button data-id="'.$post->id.'" data-status="2" type="button" class="btn btn-sm  btn-primary voucher_approved" title="Approve" style="min-width: 75px;-webkit-transform: scale(1);">Approve </button>';
                }elseif($post->vStatus==3){
                    if (auth()->user()->can('voucher_seen')){
                        $action.='<button data-id="'.$post->id.'" data-status="4" type="button" title="Seen" class="btn btn-sm  btn-primary voucher_seen_unseen" style="-webkit-transform: scale(1);"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                    }
                }
                elseif($post->vStatus==2){
                    if (auth()->user()->can('voucher_seen')){
                        $action.='<button data-id="'.$post->id.'" data-status="4" type="button" title="Seen" class="btn btn-sm  btn-primary voucher_seen_unseen" style="-webkit-transform: scale(1);"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                    }
                    if (auth()->user()->can('voucher_seen')){
                        $action.='<button data-id="'.$post->id.'" data-status="3" type="button" title="Question" class="btn btn-sm  btn-primary voucher_seen_unseen" style="-webkit-transform: scale(1);"><i class="fa fa-question-circle" aria-hidden="true"></i></button>';
                    }

                }
            }


            $records["data"][] = array(
                $id                 = $i,
                $createdAt          = date('d-m-Y',strtotime($post->createdAt)),
                $createdAtForSort   = $post->createdAtForSort,
                $name               = $post->expenseName,
                $pId                = '<a data-toggle="modal" data-target-id="'.$post->id.'" data-target="#myModal" href="">'.$post->vId.'</a>',
                $companyName        = $post->companyName?$post->companyName:'',
                $projectName        = $post->projectName?$post->projectName:'',
                $amount             = $post->amount?number_format($post->amount,2,'.',','):0.00,
                $action,
                $button
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


    public function quickView($id){

        $voucher=Voucher::find($id);

        $returnHTML = view('voucher.quick_view',['voucher'=>$voucher])->render();
        return response()->json( ['html'=>$returnHTML]);
    }


    public function store(Request $request){
        $check_id = $request->check_id?$request->check_id:'';
//        var_dump($check_id);die;
//
        $voucher_items = $request->voucher_item;
        $expenditure_sectors = $request->expenditure_sector;
        $projects_id = $request->project_id;
        $item_name = $request->item_name;
        $voucher_amount = $request->voucher_amount;
        $arrayData = array();
        if($voucher_items){
            foreach ($voucher_items as $voucher_item){
                if(isset($expenditure_sectors[$voucher_item]) && isset($projects_id[$voucher_item])){
                    $arrayData[$expenditure_sectors[$voucher_item]][$projects_id[$voucher_item]][]= array(
                        'vItemId'=>$voucher_item,
                        'project_id'=>$projects_id[$voucher_item],
                        'item_name'=>$item_name[$voucher_item],
                        'voucher_amount'=>$voucher_amount[$voucher_item],
                        );
                }
            }
        }

        if ($arrayData){
            $returnArray = array();
            foreach ($arrayData as $keyParent=>$vouchers){
                foreach ($vouchers as $keyChild => $items){
                    $voucher = new Voucher();
                    $voucher->expenditure_sector_id = $keyParent;
                    $voucher->created_by = auth()->user()->id;

                    $voucher->save();

                    foreach ($items as $item){
                        $voucherItem = VoucherItems::find($item['vItemId']);
                        $voucherItem->voucher_id = $voucher->id;
                        $voucherItem->item_name = $item['item_name'];
                        $voucherItem->project_id = $item['project_id'];
                        $voucherItem->voucher_amount = $item['voucher_amount'];
                        $voucherItem->status = 0;
                        $voucherItem->save();
                    }
                    $voucher->total_amount = $voucher->getTotalAmount();
                    $voucher->status = 0;
                    $voucher->save();

                    $returnArray[]=$voucher->id;
                }

            }
            if ($returnArray){
                return redirect()->route('voucher_draft_view',http_build_query(['vId[]'=>$returnArray,'check_id'=>$check_id]))->with('success', 'Click save and confirm to create this vouchers.');
            }
        }

       return redirect()->route('voucher_index')->with('error','Error! Ops something error.');
    }

    public function draftView(Request $request){
        $vouchers = Voucher::whereIn('id', $request->vId)->get();
        return view('voucher.draft',['vouchers'=>$vouchers]);
    }

    public function draftToConfirmStore(Request $request){
        $vouchersId = $request->voucher_id;
        $vouchers_amount = $request->voucher_amount;
        $cash_check_id = array();
        $account_pay_check_id = array();
        if ($vouchersId){
            foreach ($vouchersId as $voucherId){
                /** @var Voucher $voucher */
                $voucher = Voucher::find($voucherId);


                if(isset($vouchers_amount[$voucherId])){

                    foreach ($vouchers_amount[$voucherId] as $voucherItemId=>$amount){
                        /** @var VoucherItems $voucherItem */
                        $voucherItem = VoucherItems::find($voucherItemId);
                        $voucherItem->voucher_amount = $amount;
                        $voucherItem->status=1;
                        $voucherItem->save();

                       /* if(isset($voucherItem->checkRegistry) && $voucherItem->checkRegistry->check_type=='ACCOUNT_PAY'){
                            $account_pay_check_id[$voucher->id][]= array('voucher_id'=>$voucher->id, 'check_id'=>$voucherItem->check_registry_id);
                        }elseif (isset($voucherItem->checkRegistry) && $voucherItem->checkRegistry->check_type=='CASH'){
                            $cash_check_id[$voucher->id][]= array('voucher_id'=>$voucher->id, 'check_id'=>$voucherItem->check_registry_id);
                        }*/

                    }
                }

                $voucher->status=1;
                $voucher->total_amount=$voucher->getTotalAmount();
                $this->GenerateVoucherId($voucher);

            }
            return redirect()->route('voucher_index')->with('success', 'Voucher has been successfully created');
        }
        return redirect()->route('voucher_index')->with('error','Error! Ops something error.');
    }

    public function voucherApproved($id){
        $user = auth()->user();

        if ($id){
            $cash_check_id = array();
            $account_pay_check_id = array();
            $account_transfer_check_id = array();
            $voucher = Voucher::find($id);
            if($voucher->status==1){

                $date = date('Y-m-d');
                $from_date = $date? $date.' 00:00:00': '';
                $to_date = $date? $date.' 23:59:59': '';
                $openingBalance=$this->dailyCashSession->getDailyOpeningClosingBalance($from_date,$to_date, $voucher->VoucherItems[0]->project->company->id);
                $cashTransactions = $this->dailyCashTransaction->getDailyBalanceTransaction($date, $voucher->VoucherItems[0]->project->company->id);

                $openingBalance= isset($openingBalance[$voucher->VoucherItems[0]->project->company->id])?$openingBalance[$voucher->VoucherItems[0]->project->company->id]->opening_balance:0;

                $dailyDr=isset($cashTransactions[$voucher->VoucherItems[0]->project->company->id]['DR'])?array_sum($cashTransactions[$voucher->VoucherItems[0]->project->company->id]['DR']):0;

                $dailyCr = isset($cashTransactions[$voucher->VoucherItems[0]->project->company->id]['CR'])?array_sum($cashTransactions[$voucher->VoucherItems[0]->project->company->id]['CR']):0;

                if(($openingBalance+$dailyCr-$dailyDr)<$voucher->total_amount && !isset($voucher->VoucherItems[0]->checkRegistry)){
                    return response()->json(['message'=>'Error! In sufficient balance.','status'=>301]);
                }elseif (($openingBalance+$dailyCr-$dailyDr)<$voucher->total_amount && isset($voucher->VoucherItems[0]->checkRegistry) &&
                    $voucher->VoucherItems[0]->checkRegistry->check_type=='CASH'){
                    return response()->json(['message'=>'Error! In sufficient balance.','status'=>301]);
                }

                /** @var VoucherItems $voucherItem */
                foreach ($voucher->VoucherItems as $voucherItem){
                    $voucherItem->status=1;
                    $voucherItem->save();

                    if(isset($voucherItem->checkRegistry) && $voucherItem->checkRegistry->check_type=='ACCOUNT_PAY'){
                        $account_pay_check_id[$voucher->id][]= array('voucher_id'=>$voucher->id, 'check_id'=>$voucherItem->check_registry_id);
                    }elseif (isset($voucherItem->checkRegistry) && $voucherItem->checkRegistry->check_type=='ACCOUNT_TRANSFER'){
                        $account_transfer_check_id[$voucher->id][]= array('voucher_id'=>$voucher->id, 'check_id'=>$voucherItem->check_registry_id);
                    }elseif (isset($voucherItem->checkRegistry) && $voucherItem->checkRegistry->check_type=='CASH'){
                        $cash_check_id[$voucher->id][]= array('voucher_id'=>$voucher->id, 'check_id'=>$voucherItem->check_registry_id);
                    }

                }
                $voucher->approved_by = $user->id;
                $voucher->approved_at = new \DateTime();
                $voucher->status=2;
                $voucher->save();

                if($voucher->status==2){
                    $transactionVia='';
                    if(isset($account_pay_check_id[$voucher->id]) && sizeof(  $account_pay_check_id[$voucher->id])>0){
                        $transactionVia='VOUCHER_CHECK_ACCOUNT_PAY';
                    }elseif ( isset($account_transfer_check_id[$voucher->id]) && sizeof( $account_transfer_check_id[$voucher->id])>0){
                        $transactionVia='VOUCHER_CHECK_ACCOUNT_TRANSFER';
                    }else{
                        $transactionVia='VOUCHER';
                    }

                    $arrayData= array(
                        'transaction_type'=>'DR',
                        'transaction_via'=>$transactionVia,
                        'transaction_via_ref_id'=>$voucher->id,
                        'amount'=>$voucher->total_amount,
                        'company_id'=>$voucher->VoucherItems[0]->project?$voucher->VoucherItems[0]->project->company->id:null,
                        'project_id'=>$voucher->VoucherItems[0]->project?$voucher->VoucherItems[0]->project->id:null,
                        'created_by'=>auth()->id(),
                        'created_at'=>new \DateTime(),
                    );

                    CashTransaction::insertData($arrayData);

                    $check_id = array_merge_recursive($account_pay_check_id,$cash_check_id,$account_transfer_check_id);

                    if(sizeof($check_id)>0){

                        foreach ($check_id as $value){
                            foreach ($value as $item){
                                $checkRegistry = CheckRegistry::find($item['check_id']);
                                $checkRegistry->ref_id = $item['voucher_id'];
                                $checkRegistry->save();
                            }
                        }
                    }
                }

                return response()->json(['message' => 'Voucher has been successfully approved.', 'status' => 200]);
            }

        }
        return response()->json(['message'=>'Error! Something wrong.','status'=>301]);
    }

    public function voucherSeenUnseen(Request $request, $id){
        $paymentStatus = $request->request->get('voucher_status');
        $message='';
        if($paymentStatus==3){
            $message='question';
        }elseif ($paymentStatus==4){
            $message='seen';
        }

        if ($id && $paymentStatus){
            $voucher = Voucher::find($id);
            if($voucher->status==2||$voucher->status==3){
                $voucher->status=$paymentStatus;
                $voucher->save();

                return response()->json(['message' => 'Voucher has been successfully '.$message.'.', 'status' => 200]);
            }

        }
        return response()->json(['message'=>'Error! Something wrong.','status'=>301]);
    }

    public function details($id){
        $voucher = Voucher::find($id);
        return view('voucher.details',['voucher'=>$voucher]);
    }

    public function voucherPdf($id){
        $voucher = Voucher::find($id);
        if(auth()->user()->can('voucher_create')){
            $pdf = PDF::loadView('voucher.pdf', ['voucher'=>$voucher]);
//        return $pdf->download(time().'_payment.pdf');
            return $pdf->stream(time()."_voucher_".$voucher->id.".pdf",array("Attachment" => false));
        }
        return redirect()->route('voucher_archive_index')->with('error', 'Error! This are not permitted.');

    }

    public function voucherPrint($id){
        $voucher = Voucher::find($id);
        if(auth()->user()->can('voucher_create')) {
            return view('voucher.print', ['voucher' => $voucher]);
        }
        return redirect()->route('voucher_archive_index')->with('error', 'Error! This are not permitted.');

    }

    private function GenerateVoucherId(Voucher $voucher){
        $company = $voucher->VoucherItems[0]->project->company;
        $companyCode = $company->code;
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
        $voucher->voucher_generate_id=$sequentialId;
        $voucher->save();

        $company = Company::find($company->id);
        $company->last_voucher_id=$voucherId;
        $company->save();
    }

    public function deleteVoucherItemAjax($id){
        $voucherItem=VoucherItems::find($id);
        $voucherItem->delete();
        return new JsonResponse(['message'=>'Record has been deleted.','status'=>200]);
    }

    public function delete($id){

        $voucher=Voucher::find($id);
        if(auth()->user()->hasRole('superadmin')||auth()->user()->can('superadmin')) {
            $voucher->delete();
            return new JsonResponse(['message'=>'Voucher has been deleted.','status'=>200]);
        }
        return new JsonResponse(['message'=>'Error! Ops something wrong.','status'=>400]);

    }


}
