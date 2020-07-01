<?php

namespace App\Http\Controllers;

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
    function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:Payment-create', ['only' => ['index','create','store','approve','verify']]);
        $this->middleware('permission:voucher_approved', ['only' => ['approved']]);
        $this->middleware('permission:voucher_create', ['only' => ['index','store','voucherPdf','voucherPrint']]);


    }


    Public function index(){
        $projects=Project::all();
        $expenditureSectors = ExpenditureSector::all();
        return  view('voucher.index',['projects'=>$projects, 'expenditureSectors'=>$expenditureSectors]);
    }

    Public function archivedList(){
        $projects=Project::all();
        return  view('voucher.archive',['projects'=>$projects]);
    }

    public function dataTable(Request $request)
    {
        $expenditureSectors = ExpenditureSector::all();

        $query = $request->request->all();

        $countRecords = DB::table('voucher_items');
        $countRecords->select('voucher_items.id as totalVoucherItems');
//        $countRecords->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
        $countRecords->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $countRecords->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');
//        $countRecords->join('companies', 'payments.company_id', '=', 'companies.id');

        $countRecords->where('voucher_items.status','=', 0);
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $countRecords->where('payments.payment_id', 'like', "{$name}%");
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('voucher_items.project_id',$project_id);
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
        $rows->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');
        $rows->select('voucher_items.id as viId', 'voucher_items.item_name as name', 'voucher_items.voucher_amount as amount');
        $rows->addSelect('projects.p_name as projectName','projects.id as projectId');
        $rows->addSelect('payments.payment_id as pId');
        $rows->where('voucher_items.status','=', 0);
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $rows->where('payments.payment_id', 'like', "{$name}%");
        }
        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('voucher_items.project_id',$project_id);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);

        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $dropdown='<select name="expenditure_sector['.$post->viId.']" class="form-control">
            <option value="">Select Type</option>';
            foreach ($expenditureSectors as $expenditureSector){
                $dropdown.= '<option value="'.$expenditureSector->id.'">'.$expenditureSector->name.'</option>';
            }

            $dropdown .='</select>';

            $checkbox = '<input type="checkbox" name="voucher_item[]" value="'.$post->viId.'">';
            $button = '<button type="button" data-id="'.$post->viId.'" class="btn btn-danger remove_row">X</button>';

            $records["data"][] = array(
                $checkbox,
                $dropdown,
                $name               = '<input type="hidden" value="'.$post->name.'" name="item_name['.$post->viId.']">'.$post->name,
                $pId                = $post->pId,
                $projectName        = $post->projectName?'<input type="hidden" value="'.$post->projectId.'" name="project_id['.$post->viId.']">'.$post->projectName:'',
                $amount             = '<input type="hidden" value="'.$post->amount.'" name="voucher_amount['.$post->viId.']">'.$post->amount,
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

    public function dataTableArchived(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('vouchers');
        $countRecords->select('vouchers.id as totalVouchers');
        $countRecords->join('voucher_items', 'vouchers.id', '=', 'voucher_items.voucher_id');
        $countRecords->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $countRecords->join('companies', 'projects.company_id', '=', 'companies.id');
        $countRecords->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');

        $countRecords->where('voucher_items.status','!=', 0);
        if (isset($query['voucher_id'])) {
            $name = $query['voucher_id'];
            $countRecords->where('vouchers.voucher_generate_id', 'like', "{$name}%");
        }

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('voucher_items.project_id',$project_id);
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

        $rows->select('vouchers.id as id', 'vouchers.voucher_generate_id as vId', 'vouchers.total_amount as amount');
        $rows->addSelect( 'voucher_items.item_name as name', 'voucher_items.voucher_id as voucherId');
        $rows->addSelect('projects.p_name as projectName');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('payments.payment_id as pId');

        $rows->join('voucher_items', 'vouchers.id', '=', 'voucher_items.voucher_id');
        $rows->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $rows->join('companies', 'projects.company_id', '=', 'companies.id');
        $rows->leftJoin('payments', 'voucher_items.payment_id', '=', 'payments.id');

        $rows->where('voucher_items.status','!=', 0);

        if (isset($query['voucher_id'])) {
            $name = $query['voucher_id'];
            $rows->where('vouchers.voucher_generate_id', 'like', "{$name}%");
        }
        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('voucher_items.project_id',$project_id);
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

            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $name               = $post->name,
                $pId                = $post->vId,
                $companyName        = $post->companyName?$post->companyName:'',
                $projectName        = $post->projectName?$post->projectName:'',
                $amount             = $post->amount,
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


    public function store(Request $request){
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

//        var_dump($arrayData);die;

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
                    $this->GenerateVocherId($voucher);

                    $returnArray[]=$voucher->id;
                }

            }
            if ($returnArray){
                return redirect()->route('voucher_draft_view',http_build_query(['vId[]'=>$returnArray]))->with('success', 'Click save and confirm to create this vouchers.');
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
        if ($vouchersId){
            foreach ($vouchersId as $voucherId){
                /** @var Voucher $voucher */
                $voucher = Voucher::find($voucherId);


                if(isset($vouchers_amount[$voucherId])){

                    foreach ($vouchers_amount[$voucherId] as $voucherItemId=>$amount){
                        $voucherItem = VoucherItems::find($voucherItemId);
                        $voucherItem->voucher_amount = $amount;
                        $voucherItem->status=1;
                        $voucherItem->save();
                    }
                }

                $voucher->status=1;
                $voucher->total_amount=$voucher->getTotalAmount();
                $voucher->save();

            }
            return redirect()->route('voucher_index')->with('success', 'Voucher has been successfully created');
        }
        return redirect()->route('voucher_index')->with('error','Error! Ops something error.');
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

    private function GenerateVocherId(Voucher $voucher){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($voucher->id,4, '0', STR_PAD_LEFT));
        $voucher->voucher_generate_id=$sequentialId;
        $voucher->save();
    }

    public function deleteVoucherItemAjax($id){
        $voucherItem=VoucherItems::find($id);
        $voucherItem->delete();
        return new JsonResponse(['message'=>'Record has been deleted.','status'=>200]);
    }


}
