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

class VoucherController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:Payment-create', ['only' => ['index','create','store','approve','verify']]);
        $this->middleware('permission:voucher_approved', ['only' => ['approved']]);
        $this->middleware('permission:voucher_create', ['only' => ['index','store']]);


    }


    Public function index(){
        $projects=Project::all();
        return  view('voucher.index',['projects'=>$projects]);
    }


    public function dataTable(Request $request)
    {
        $expenditureSectors = ExpenditureSector::all();

        $query = $request->request->all();

        $countRecords = DB::table('voucher_items');
        $countRecords->select('voucher_items.id as totalVoucherItems');
//        $countRecords->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
        $countRecords->join('projects', 'voucher_items.project_id', '=', 'projects.id');
        $countRecords->join('payments', 'voucher_items.payment_id', '=', 'payments.id');
//        $countRecords->join('companies', 'payments.company_id', '=', 'companies.id');

        $countRecords->where('voucher_items.status','==', 0);

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('payments.project_id',$project_id);
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
        $rows->join('payments', 'voucher_items.payment_id', '=', 'payments.id');
        $rows->select('voucher_items.id as viId', 'voucher_items.item_name as name', 'voucher_items.voucher_amount as amount');
        $rows->addSelect('projects.p_name as projectName','projects.id as projectId');
        $rows->addSelect('payments.payment_id as pId');
        $rows->where('voucher_items.status','==', 0);

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('payments.project_id',$project_id);
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


            $records["data"][] = array(
                $checkbox,
                $dropdown,
                $name               = $post->name,
                $pId                = $post->pId,
                $projectName        = $post->projectName?'<input type="hidden" value="'.$post->projectId.'" name="project_id['.$post->viId.']">'.$post->projectName:'',
                $amount             = '<input type="hidden" value="'.$post->amount.'" name="voucher_amount['.$post->viId.']">'.$post->amount,
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
        $arrayData = array();
        if($voucher_items){
            foreach ($voucher_items as $voucher_item){
                if(isset($expenditure_sectors[$voucher_item])){
                    $arrayData[$expenditure_sectors[$voucher_item]][]= $voucher_item;
                }
            }
        }

        if ($arrayData){
            foreach ($arrayData as $key=>$items){
                $voucher = new Voucher();
                $voucher->expenditure_sector_id = $key;
                $voucher->created_by = auth()->user()->id;

                $voucher->save();

                foreach ($items as $item){
                    $voucherItem = VoucherItems::find($item);
                    $voucherItem->voucher_id = $voucher->id;
                    $voucherItem->status = 1;
                    $voucherItem->save();
                }
                $voucher->total_amount = $voucher->getTotalAmount();
                $this->GenerateVocherId($voucher);

            }
        }

       return redirect()->route('voucher_index');
    }

    private function GenerateVocherId(Voucher $voucher){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($voucher->id,4, '0', STR_PAD_LEFT));
        $voucher->voucher_generate_id=$sequentialId;
        $voucher->save();
    }


}
