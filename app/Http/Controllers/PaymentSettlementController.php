<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\Payment;
use App\PaymentSettlement;
use App\VoucherItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentSettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:payment-settlement-list', ['only' => ['index']]);
        $this->middleware('permission:payment-settlement-create', ['only' => ['store']]);
        $this->middleware('permission:payment-settlement-delete',['only'=>['delete']]);
    }


    public function index(){

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

        $settlements=PaymentSettlement::all();

        return view('settlement.index',['settlements'=>$settlements,'companies'=>$companies,'projects'=>$projects]);

    }

    public function dataTablePaymentSettlement(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('payment_settlements');
        $countRecords->select('payment_settlements.id as totalSettlement');
        $countRecords->join('projects', 'payment_settlements.project_id', '=', 'projects.id');
        $countRecords->join('companies', 'projects.company_id', '=', 'companies.id');
        $countRecords->join('payments', 'payment_settlements.payment_id', '=', 'payments.id');

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $countRecords->where('payment_settlements.project_id',$project_id);
        }

        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('companies.id',$company_id);
        }
        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].'00:00:00';
            $to_date = $query['to_date'].'23:59:59';
            $countRecords->whereBetween('payment_settlements.created_at', [$from_date, $to_date]);
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

        $rows = DB::table('payment_settlements');
        $rows->select('payment_settlements.id as id', 'payment_settlements.settlement_amount as amount');
        $rows->addSelect('projects.p_name as projectName');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('payments.payment_id as pId');
        $rows->join('projects', 'payment_settlements.project_id', '=', 'projects.id');
        $rows->join('companies', 'projects.company_id', '=', 'companies.id');
        $rows->leftJoin('payments', 'payment_settlements.payment_id', '=', 'payments.id');

        if(isset($query['project_id'])){
            $project_id = $query['project_id'];
            $rows->where('payment_settlements.project_id',$project_id);
        }
        if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('companies.id',$company_id);
        }
        if (isset($query['from_date']) && isset($query['to_date'])) {
            $from_date = $query['from_date'].' 00:00:00';
            $to_date = $query['to_date'].' 23:59:59';
            $rows->whereBetween('payment_settlements.created_at', [$from_date, $to_date]);
        }
        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;


        foreach ($result as $post):

            $records["data"][] = array(
                $id                 = $i,
                $pId                = $post->pId,
                $companyName        = $post->companyName?$post->companyName:'',
                $projectName        = $post->projectName?$post->projectName:'',
                $amount             = $post->amount,
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


    public function store(Request $request ,$id){

        $payment=Payment::find($id);

        $settlement = new PaymentSettlement();

        $settlement->settlement_amount= $request->settlement_amount;
        $settlement->payment_id= $payment->id;
        $settlement->project_id= $payment->project->id;
        $settlement->type= 'SETTLE';

        $settlement->save();

        if(sizeof($payment->voucherItems)<1){
            foreach ($payment->Payment_details as $payment_detail){
                $voucherItem= new VoucherItems();
                $voucherItem->item_name= $payment_detail->item_name;
                $voucherItem->payment_amount= $payment_detail->paid_amount;
                $voucherItem->voucher_amount= $payment_detail->paid_amount;
                $voucherItem->payment_id= $payment->id;
                $voucherItem->payment_details_id = $payment_detail->id;
                $voucherItem->project_id = $payment_detail->project->id;
                $voucherItem->save();
            }
        }

        $totalSettleAmount = $this->getTotalSettlementAmount($payment);

        if($payment->total_paid_amount>$totalSettleAmount){
            $payment->status = 5;
        }
        if($payment->total_paid_amount == $totalSettleAmount){
            $payment->status = 6;
        }
        $payment->save();

        $arrayData= array(
            'transaction_type'=>'CR',
            'transaction_via'=>'HAND_SLIP_SETTLE',
            'transaction_via_ref_id'=>$payment->id,
            'amount'=>$settlement->settlement_amount,
            'company_id'=>$payment->company_id,
            'project_id'=>$settlement->project_id?$settlement->project_id:null,
            'created_by'=>auth()->id(),
            'created_at'=>new \DateTime(),
        );
        CashTransaction::insertData($arrayData);


        return redirect()->route('details',$payment->id)->with('success','Settlement has been successfully created.');
    }

    private function getTotalSettlementAmount(Payment $payment){
        return $payment->getTotalPaymentSettlementAmount();
    }


}
