<?php

namespace App\Http\Controllers;

use App\Ammendment;
use App\Payment_details;
use App\Project;
use App\User;
use App\UserProfile;
use App\UserType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Payment;
use App\Company;
use App\Account;
use Illuminate\Support\Facades\DB;
use PDF;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Payment-create', ['only' => ['create','store']]);
        $this->middleware('permission:payment-verify', ['only' => ['verify']]);
        $this->middleware('permission:payment-approve', ['only' => ['approve']]);
        $this->middleware('permission:payment-index', ['only' => ['index']]);
        $this->middleware('permission:payment-edit',['only'=>['edite']]);
        $this->middleware('permission:payment-delete',['only'=>['delete']]);
        $this->middleware('permission:payment-paid',['only'=>['payment_paid']]);


    }


    public function index(){

        $payments=Payment::orderBy('created_at','DSC')->paginate(25);
        $companies=Company::all();
        $projects=Project::all();
        $users=User::all();

        $amendments=Ammendment::all();

        return view('payment.payment_index',['payments'=>$payments,'users'=>$users,'companies'=>$companies,'projects'=>$projects])->with('i', (request()->input('page', 1) - 1) * 25);
    }

    public function create(){

       $users=User::all();
       if(auth()->user()->hasRole('Employee') || auth()->user()->hasRole('Vendor')){
           $user= auth()->user();
           $users=User::where('id', $user->id)->get();
       }

        $companies=Company::all();
        $projects=Project::all();

        return view('payment.create',['users'=>$users, 'companies'=>$companies ,'projects'=>$projects]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $paid_amount=$request->paid_amount;

        $projects=$request->project_id;
        $itemName=$request->item_name;
        $newArray = array();
        $returnArray = array();
        foreach ($projects as $key => $project){
            if($project>0){
                $newArray[$project][]= array('project_id'=>$project,'itemName'=>$itemName[$key],'amount'=>$paid_amount[$key]);
            }
        }

        foreach ($newArray as $newKey=>$arrayValue){

            $payment=new Payment();
            $payment->user_id=$request->user_id;
            $payment->comments=$request->comments;
            $payment->company_id=$request->company_id;
            $payment->project_id=$newKey;
            $payment->created_by=$user->id;
            $payment->total_demand_amount=0;
            $payment->total_paid_amount=0;
            $payment->status=0;

            $payment->save();

            foreach ($arrayValue as $key=>$value){
                $paymentDetails = new Payment_details();
                $paymentDetails->project_id=$value['project_id'];
                $paymentDetails->item_name=$value['itemName'];
                $paymentDetails->demand_amount=$value['amount'];
                $paymentDetails->paid_amount=$value['amount'];

                $payment->Payment_details()->save($paymentDetails);
            }

            $this->setTotalPaidAmount($payment);

            $this->GeneratePaymentId($payment);

            $returnArray[]=$payment->id;
        }

        if ($returnArray){
            return redirect()->route('payment_draft_view',http_build_query(['payment[]'=>$returnArray]))->with('success', 'Click save and confirm to create this handslip.');
        }


        return redirect()->route('payment')->with('success', 'Payment has been successfully Submitted pending for Confirmation');

    }

    public function draftView(Request $request){
        $payments = Payment::whereIn('id', $request->payment)->get();

        return view('payment.draft',['payments'=>$payments]);

    }

    public function draftToConfirmStore(Request $request){
        $paymentsId = $request->payment_id;

        foreach ($paymentsId as $paymentId){
            $payment = Payment::find($paymentId);
            $payment->status = 1;
            $payment->save();
        }

        return redirect()->route('payment')->with('success', 'Payment has been successfully Created');
    }

    private function setTotalPaidAmount(Payment $payment){

        $payment->total_demand_amount=$payment->getTotalPaidAmount();
        $payment->total_paid_amount=$payment->getTotalPaidAmount();
        $payment->save();
    }

    private function GeneratePaymentId(Payment $payment){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($payment->id,4, '0', STR_PAD_LEFT));

        $payment->payment_id=$sequentialId;
        $payment->save();
    }



    public function quickView($id){

        $payment=Payment::find($id);
        $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
        $returnHTML = view('payment.quick_view',['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount])->render();
        return response()->json( ['html'=>$returnHTML]);
    }


    public function paymentPDF($id){

        $payment=Payment::find($id);
        $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
        $pdf = PDF::loadView('payment.pdf_view', ['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
//        return $pdf->download(time().'_payment.pdf');
        return $pdf->stream(time()."_hand_slip.pdf",array("Attachment" => false));
    }

    public function paymentPrint($id){
        $payment=Payment::find($id);
        $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
        return view('payment.payment-print',['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
    }

    public function edite($id){

        //$payment = \DB::table('payments')->where('id', $id)->first();
        $payment=Payment::find($id);

        if($payment->status>1){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }

        $companies=Company::all();
        $user=User::all();
        $paymentDetails=Payment_details::all();

        $companyProjects = $payment->company->project;
        $companyData = array();
        if($companyProjects){

            foreach ($companyProjects as $companyProject){
                $companyData[$companyProject->id]=array(
                    'id'=> $companyProject->id,
                    'name'=> $companyProject->p_name,
                );
            }
        }

        $userProjects = $payment->user->projects;
        $data = array();
        if($userProjects){

            foreach ($userProjects as $userProject){
                $data[$userProject->id]=array(
                    'id'=> $userProject->id,
                    'name'=> $userProject->p_name,
                );
            }
        }

        $creatorUserProjects = auth()->user()->projects;
        $creatorUserData = array();
        if($creatorUserProjects){
            foreach ($creatorUserProjects as $creatorUserProject){
                $creatorUserData[$creatorUserProject->id]=array(
                    'id'=> $creatorUserProject->id,
                    'name'=> $creatorUserProject->p_name,
                );
            }
        }
        $projects=array_intersect_key($data,$creatorUserData,$companyData);

        return view('payment.edite',['payment'=>$payment ,'companies'=>$companies ,'users'=>$user,'projects'=>$projects ,'paymentDetails'=>$paymentDetails]);

    }


    public function update(Request $request,$id){

        $payment=Payment::find($id);
        if($payment->status>1){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }
        $user = auth()->user();
        $paid_amount=$request->paid_amount?$request->paid_amount:array(0);
        $exit_paid_amount=$request->exit_paid_amount?$request->exit_paid_amount:array(0);
        $payment->user_id=$request->user_id;
        $payment->company_id=$request->company_id;
        $payment->project_id=$request->exit_project_id[0];
        $payment->comments=$request->comments;

        $payment->created_by=$user->id;
        $payment->save();
        $projects=$request->project_id;
        $itemName=$request->item_name;

        if($projects){
            foreach ($projects as $key=>$project){
                if($project>0 && $paid_amount[$key]>0){
                    $paymentDetails = new Payment_details();
                    $paymentDetails->item_name=$itemName[$key];
                    $paymentDetails->project_id=$project;
                    $paymentDetails->demand_amount=$paid_amount[$key];
                    $paymentDetails->paid_amount=$paid_amount[$key];
                    $payment->Payment_details()->save($paymentDetails);
                }
            }
        }
        $exit_payment_details=$request->exit_payment_detail;
        $exitItemName=$request->exit_item_name;
        if($exit_payment_details){
            foreach ($exit_payment_details as $key=>$detail){
                $paymentDetails = Payment_details::find($detail);
                $paymentDetails->item_name=$exitItemName[$key];
                $paymentDetails->project_id =$request->exit_project_id[$key];
                $paymentDetails->demand_amount=$exit_paid_amount[$key];
                $paymentDetails->paid_amount=$exit_paid_amount[$key];
                $payment->Payment_details()->save($paymentDetails);
            }
        }
        $this->setTotalPaidAmount($payment);

        return redirect()->route('payment')->with('success', 'Payment has been successfully Updated.');
    }
    //verify
    public function verify(Request $request, $id){
        $user = auth()->user();
        $status = $request->post('payment_status');

        $payment=Payment::find($id);
        if($payment->status==1 ||$payment->status==2){
            if($status==1){
                $msg="un verified.";
            }else{
                $msg="verified.";
            }
            $payment->status=$status;
            $payment->verified_by=$status==2?$user->id:null;
            $payment->verified_at= new \DateTime();
            //$payment->status=2;
            $payment->save();
            return response()->json(['message'=>'Payment has been successfully '.$msg,'status'=>200]);

        }
        return response()->json(['message'=>'Error! This are not permitted.','status'=>301]);

    }

    //approved by
    public function approve($id){
        $user = auth()->user();
        $payment=Payment::find($id);
        //$payment->status=1;
        if($payment->status==2) {
            $payment->approved_by = $user->id;
            $payment->approved_at = new \DateTime();
            $payment->status = 3;
            $payment->save();
            return response()->json(['message' => 'Payment has been successfully approved.', 'status' => 200]);
        }
        return response()->json(['message'=>'Error! This are not permitted.','status'=>301]);
    }
    public function payment_paid($id){
        $user = auth()->user();
        $payment=Payment::find($id);
        //$payment->status=1;
        if($payment->status==3) {
            $payment->disbursed_by = $user->id;
            $payment->disbursed_at = new \DateTime();
            $payment->status = 4;
            $payment->save();
            return response()->json(['success' => 'Payment has been successfully disbursed.', 'status' => 200]);
        }
        return response()->json(['message'=>'Error! This are not permitted.','status'=>301]);
    }

    public function details($id){

        $payment=Payment::find($id);
        $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
        return view('payment.details',['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
    }

    private function getTotalSettlementAmount(Payment $payment){
        return $payment->getTotalPaymentSettlementAmount();
    }

       public function  Voucher($id){

       $payment=Payment::find($id);
       $amendment = $payment->ammendment;
       $total=$amendment->sum('additional_amount');
       return view('voucher.index',['payment'=>$payment,'total'=>$total]);
    }

    public function delete($id){
        $payment=Payment::find($id);
        if($payment->status>1){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }
        $payment->delete();
        return redirect()->route('payment')->with('success', 'Payment has been successfully deleted.');
    }

    public function dataTable(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('payments');
        $countRecords->select('payments.id as totalPayment');
//        $countRecords->join('payment_details', 'payments.id', '=', 'payment_details.payment_id');
//        $countRecords->join('projects', 'payment_details.project_id', '=', 'projects.id');
        $countRecords->join('users as employee', 'payments.user_id', '=', 'employee.id');
        $countRecords->join('users as createdBy', 'payments.created_by', '=', 'createdBy.id');
        $countRecords->join('companies', 'payments.company_id', '=', 'companies.id');

        $countRecords->where('payments.status','!=', 0);

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
        if(auth()->user()->hasRole('Employee') || auth()->user()->hasRole('Vendor')){
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
//        $rows->join('projects', 'payment_details.project_id', '=', 'projects.id');
        $rows->join('users as employee', 'payments.user_id', '=', 'employee.id');
        $rows->join('users as createdBy', 'payments.created_by', '=', 'createdBy.id');
        $rows->join('companies', 'payments.company_id', '=', 'companies.id');
        $rows->select('payments.id as pId', 'payments.payment_id as name', 'payments.total_paid_amount as amount', 'payments.status as pStatus', 'payments.created_at as created_at', 'payments.verified_at as paymentVerifyAt');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('employee.name as employeeName');
        $rows->addSelect('createdBy.name as creatorName');
        $rows->where('payments.status','!=', 0);
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
        if(auth()->user()->hasRole('Employee') || auth()->user()->hasRole('Vendor')){
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

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):
            $paymentStatus = '';
            if ($post->pStatus == 1 && $post->paymentVerifyAt == null) {
                $paymentStatus = '<span class="label label-yellow">Created but not verified</span>';
            } elseif ($post->pStatus == 1 && $post->paymentVerifyAt != null) {
                $paymentStatus = '<span class="label label-yellow">Waiting for verified</span>';
            } elseif ($post->pStatus == 2) {
                $paymentStatus = '<span class="label label-orange">Verified but not approved</span>';
            } elseif ($post->pStatus == 3) {
                $paymentStatus = '<span class="label label-green">HS has been approved</span>';
            } elseif ($post->pStatus == 4) {
                $paymentStatus = '<span class="label label-blue">HS has been disbursed</span>';
            } elseif ($post->pStatus == 5) {
                $paymentStatus = '<span class="label label-light-grey">Money partially returned</span>';
            } elseif ($post->pStatus == 6) {
                $paymentStatus = '<span class="label label-grey">Money fully settled</span>';
            }

            $action='';
            if($post->pStatus==1 && auth()->user()->can('payment-verify')){
                $action.='<button data-id="'.$post->pId.'" data-status="2" type="button" class="btn btn-sm  btn-primary verify" style="min-width: 73px">Verify </button>';
            }elseif($post->pStatus==2){
                if (auth()->user()->can('payment-approve')){
                    $action.='<button data-id-id="'.$post->pId.'" type="button" class="btn btn-sm  btn-primary approved">Approve </button>';
                }
                if (auth()->user()->can('payment-verify')){
                    $action.='<button data-id="'.$post->pId.'" data-status="1" type="button" class="btn btn-sm  btn-primary verify">Un verify</button>';
                }
            }

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if ($post->pStatus == 1 && auth()->user()->can('payment-edit')) {
                $button .= '<li class="dropdown-item"> <a href="/payment/edit/'.$post->pId.'"> <i class="feather icon-edit"></i> Edit</a></li>';
            }
            if ($post->pStatus < 2 && auth()->user()->can('payment-delete')) {
                $button .='<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/payment/delete/'.$post->pId.'" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
            }

            $button .='<li class="dropdown-item"><a href="/payment/details/'.$post->pId.'"><i class="feather icon-eye"></i>Details</a></li>';

            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $createdAt          = date('d-m-Y',strtotime($post->created_at)),
                $name               = '<a data-toggle="modal" data-target-id="'.$post->pId.'" data-target="#myModal" href="javascript:void(0)">'.$post->name.'</a>',
                $employeeName       = $post->employeeName,
                $companyName        = $post->companyName?$post->companyName:'',
                $amount             = $post->amount,
//                $creatorName        = $post->creatorName,
                $pStatus            = $paymentStatus,

                $action,
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
