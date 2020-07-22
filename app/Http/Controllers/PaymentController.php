<?php

namespace App\Http\Controllers;

use App\Ammendment;
use App\Documents;
use App\Payment_details;
use App\PaymentComments;
use App\PaymentSettlement;
use App\PaymentTransfer;
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
        $user = auth()->user();
        $payments=Payment::orderBy('created_at','DSC')->paginate(25);
//        $companies=Company::withTrashed()->get();
        $projects=$user->projects;
        $pUser= array();
        foreach ($projects as $project){
            foreach ($project->users as $user){
                $pUser[$user->id]= array('id'=>$user->id,'name'=>$user->name);
            }
        }

        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $pUser), SORT_ASC, $pUser);

        $users=$pUser;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= array('id'=>$project->company->id,'name'=>$project->company->name);
        }

        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $userProjectCompany), SORT_ASC, $userProjectCompany);

        $companies=$userProjectCompany;

        return view('payment.payment_index',['payments'=>$payments,'users'=>$users,'companies'=>$companies,'projects'=>$projects])->with('i', (request()->input('page', 1) - 1) * 25);
    }

    public function create(Request $request){

        $paymentUser=null;
        $paymentCompany=null;
        if ($request->reference_payment_id==''){
            $request->session()->forget('reference_payment_id');
            $request->session()->forget('transfer_amount');
        }

        if ($request->session()->get('reference_payment_id')){
            $payment = Payment::find($request->session()->get('reference_payment_id'));
            $paymentUser = $payment?$payment->user_id:null;
            $paymentCompany = $payment?$payment->company_id:null;

            if($payment->user->trashed() || $payment->company->trashed()){
                return redirect()->route('payment')->with('error', 'Error! This company deleted.');
            }
        }


       if (auth()->user()->can('payment-create-other-user')){
           $users=User::all();
       }else{
           $user= auth()->user();
           $users=User::where('id', $user->id)->get();
       }

        $companies=Company::all();
        $projects=Project::all();

        return view('payment.create',['users'=>$users, 'companies'=>$companies ,'projects'=>$projects,'paymentUser'=>$paymentUser,'paymentCompany'=>$paymentCompany]);
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
//            $payment->comments=$request->comments;
            $payment->company_id=$request->company_id;
            $payment->project_id=$newKey;
            $payment->created_by=$user->id;
            $payment->disbursed_schedule_date = new \DateTime();
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

            if($request->comments){
                $paymentComment = new PaymentComments();
                $paymentComment->comments = $request->comments;
                $paymentComment->created_by = $user->id;
                $payment->PaymentComments()->save($paymentComment);
            }

            $this->setTotalPaidAmount($payment);

            $this->GeneratePaymentId($payment);

            $returnArray[]=$payment->id;
        }

        if ($returnArray){
            return redirect()->route('payment_draft_view',http_build_query(['payment[]'=>$returnArray]))->with('success', 'Click save and confirm to create this handslip.');
        }


        return redirect()->route('payment')->with('error', 'Error! something wrong. Please try again.');

    }

    public function commentStore(Request $request, $id){

        /** @var Payment $payment*/
        $payment = Payment::find($id);
        if($request->comments){
            $paymentComment = new PaymentComments();
            $paymentComment->comments = $request->comments;
            $paymentComment->created_by = auth()->user()->id;
            $payment->PaymentComments()->save($paymentComment);
            return redirect()->route('details',$payment->id)->with('success','Comments has been successfully created.');
        }
        return redirect()->route('details',$payment->id)->with('error','Error! Ops something wrong.');
    }

    public function paymentAttachmentStore(Request $request, $id){

        $files = $request->file('payment_attachment');
        /** @var Payment $payment*/
        $payment = Payment::find($id);
        if (isset($files) && $files!=null){
            $i=1;
            foreach ($files as $attachment){
                if ($attachment->getClientOriginalName()) {
                    $document = new Documents();
                    $filename = $attachment->getClientOriginalName();
                    $modifyFilename = time()."_".$i."_".$filename;
                    $document->payment_id = $payment->id;
                    $document->file_name = $modifyFilename;
                    $document->file_path = 'uploads/hand_slip/'.$modifyFilename;
                    $attachment->move(public_path() .'/uploads/hand_slip/', $modifyFilename);
                    $document->created_by = auth()->user()->id;
                    $document->save();
                }
                $i++;
            }
            return redirect()->route('details',$payment->id)->with('success','Attachment has been successfully uploaded.');
        }
        return redirect()->route('details',$payment->id)->with('error','Error! Ops something wrong.');
    }

    public function draftView(Request $request){
        $payments = Payment::whereIn('id', $request->payment)->get();

        return view('payment.draft',['payments'=>$payments]);

    }

    public function draftToConfirmStore(Request $request){
        $paymentsId = $request->payment_id;
        $disbursed_schedule_date = $request->disbursed_schedule_date;

        $msg = 'created.';
        $total_transfer_amount = 0;
        foreach ($paymentsId as $paymentId){
            $payment = Payment::find($paymentId);
            if($request->session()->get('reference_payment_id')){
                $refPayment = Payment::find($request->session()->get('reference_payment_id'));
                $payment->status = 3;
                $payment->payment_type = 2;
                $payment->verified_by = $refPayment->verified_by;
                $payment->verified_at = $refPayment->verified_at;
                $payment->approved_by = $refPayment->approved_by;
                $payment->approved_at = $refPayment->approved_at;
            }else{
                $payment->status = 1;
            }
            $payment->disbursed_schedule_date= new \DateTime($disbursed_schedule_date[$paymentId]);
            if(date("Y-m-d", strtotime("now"))<date("Y-m-d", strtotime($disbursed_schedule_date[$paymentId]))){
                $payment->status = 7;
            }
            $payment->save();

            if($request->session()->get('reference_payment_id')){
                $transferred = new PaymentTransfer();
                $transferred->transfer_amount = $payment->total_paid_amount;
                $transferred->payment_id = $payment->id;
                $transferred->reference_payment_id = $request->session()->get('reference_payment_id');
                $transferred->save();

                $total_transfer_amount += $payment->total_paid_amount;
            }

            $files = $request->file('payment_attachment');

            if (isset($files[$paymentId]) && $files[$paymentId]!=null){
                $i=1;
                foreach ($files[$paymentId] as $attachment){
                    if ($attachment->getClientOriginalName()) {
                        $document = new Documents();
                        $filename = $attachment->getClientOriginalName();
                        $modifyFilename = time()."_".$i."_".$filename;
                        $document->payment_id = $payment->id;
                        $document->file_name = $modifyFilename;
                        $document->file_path = 'uploads/hand_slip/'.$modifyFilename;
                        $attachment->move(public_path() .'/uploads/hand_slip/', $modifyFilename);
                        $document->created_by = auth()->user()->id;
                        $document->save();
                    }
                    $i++;
                }
            }

        }
        if($request->session()->get('reference_payment_id')){
            $refPayment = Payment::find($request->session()->get('reference_payment_id'));

            $settlement = new PaymentSettlement();

            $settlement->settlement_amount = $total_transfer_amount;
            $settlement->payment_id= $refPayment->id;
            $settlement->project_id= $refPayment->project->id;
            $settlement->type= 'TRANSFER';

            $settlement->save();

            $msg = 'transferred.';

            $totalSettleAmount = $this->getTotalSettlementAmount($refPayment);
            if($refPayment->total_paid_amount>$totalSettleAmount){
                $refPayment->status = 5;
            }
            if($refPayment->total_paid_amount <= $totalSettleAmount){
                $refPayment->status = 6;
            }

            $refPayment->save();
        }

        $request->session()->forget('transfer_amount');
        $request->session()->forget('reference_payment_id');

        return redirect()->route('payment')->with('success', 'Payment has been successfully '.$msg);
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
        if($this->checkAuthUserProjects($payment)){
            $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
            $pdf = PDF::loadView('payment.pdf_view', ['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
//        return $pdf->download(time().'_payment.pdf');
            return $pdf->stream(time()."_hand_slip.pdf",array("Attachment" => false));
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');

    }

    public function paymentPrint($id){
        $payment=Payment::find($id);
        if($this->checkAuthUserProjects($payment)){
            $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
            return view('payment.payment-print',['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
    }

    public function edite($id){

        $payment=Payment::find($id);

        if(!$this->checkAuthUserProjects($payment)){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }elseif ($payment->status>1 && auth()->user()->can('payment-edit') && !auth()->user()->hasRole('superadmin') ){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }elseif ($payment->status>3 && auth()->user()->can('payment-edit') && auth()->user()->hasRole('superadmin') ){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }
        if ($payment->user->trashed() || $payment->company->trashed() || $payment->project->trashed()) {
            return redirect()->route('payment')->with('error', 'Error! This are not edited.');
        }

        $companies=Company::withTrashed()->get();
        $user=User::withTrashed()->get();
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
        if(!$this->checkAuthUserProjects($payment)){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }elseif ($payment->status>1 && auth()->user()->can('payment-edit') && !auth()->user()->hasRole('superadmin') ){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }elseif ($payment->status>3 && auth()->user()->can('payment-edit') && auth()->user()->hasRole('superadmin') ){
            return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
        }
        $user = auth()->user();
        $paid_amount=$request->paid_amount?$request->paid_amount:array(0);
        $exit_paid_amount=$request->exit_paid_amount?$request->exit_paid_amount:array(0);
        $payment->user_id=$request->user_id;
        $payment->company_id=$request->company_id;
        $payment->project_id=$request->exit_project_id[0];
//        $payment->comments=$request->comments;

        $payment->disbursed_schedule_date = new \DateTime($request->disbursed_schedule_date);
        if(date("Y-m-d", strtotime("now"))<date("Y-m-d", strtotime($request->disbursed_schedule_date))){
            $payment->status = 7;
        }
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
        if($request->comments){
            $paymentComment = new PaymentComments();
            $paymentComment->comments = $request->comments;
            $paymentComment->created_by = $user->id;
            $payment->PaymentComments()->save($paymentComment);
        }

        $this->setTotalPaidAmount($payment);

        return redirect()->route('payment')->with('success', 'Payment has been successfully Updated.');
    }
    //verify
    public function verify(Request $request, $id){
        $user = auth()->user();
        $status = $request->post('payment_status');

        $payment=Payment::find($id);
        if($user->id!=''&& $payment->status==1 ||$payment->status==2){
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
    //un park
    public function unPark(Request $request, $id){
        $user = auth()->user();
        $status = $request->post('payment_status');

        $payment=Payment::find($id);
        if($user->id!=''&& $payment->status==7){

            $payment->status=$status;
            $payment->save();
            return response()->json(['message'=>'Payment has been successfully un park','status'=>200]);

        }
        return response()->json(['message'=>'Error! This are not permitted.','status'=>301]);

    }

    //approved by
    public function approve($id){
        $user = auth()->user();
        $payment=Payment::find($id);
        //$payment->status=1;
        if($user->id!='' && $payment->status==2 && $this->checkAuthUserProjects($payment)) {
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
        if($payment->status==3 && $this->checkAuthUserProjects($payment)) {
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
        if ($this->checkAuthUserProjects($payment)){
            $totalSettlementAmount = $this->getTotalSettlementAmount($payment);
            return view('payment.details',['payment'=>$payment, 'totalSettlementAmount'=>$totalSettlementAmount]);
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
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
        if($payment->status>1 || !$this->checkAuthUserProjects($payment)){
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
        $countRecords->join('projects', 'payments.project_id', '=', 'projects.id');
        $countRecords->join('users as employee', 'payments.user_id', '=', 'employee.id');
        $countRecords->join('users as createdBy', 'payments.created_by', '=', 'createdBy.id');
        $countRecords->join('companies', 'payments.company_id', '=', 'companies.id');

        $countRecords->where('payments.status','!=', 0);

        if (isset($query['payment_status'])) {
            $status = $query['payment_status'];
            if($status=='all'){
                $countRecords->where('payments.status','!=', 6);
                $countRecords->where('payments.status','!=', 7);
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
                $rows->where('payments.status','!=', 7);
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
            } elseif ($post->pStatus == 7) {
                $paymentStatus = '<span class="label label-yellow">Park</span>';
            }


            $action='';

            if ($post->employeeDeletedAt==null && $post->companyDeletedAt==null && $post->projectDeletedAt==null){
                if($post->pStatus==1 && auth()->user()->can('payment-verify')){
                    $action.='<button data-id="'.$post->pId.'" data-status="2" type="button" class="btn btn-sm  btn-primary verify" style="min-width: 75px;-webkit-transform: scale(1);">Verify </button>';
                }elseif($post->pStatus==7 && auth()->user()->can('payment-verify')){
                    $action.='<button data-id="'.$post->pId.'" data-status="1" type="button" class="btn btn-sm  btn-primary un_park" style="min-width: 75px;-webkit-transform: scale(1);">Un Park </button>';
                }
                elseif($post->pStatus==2){
                    if (auth()->user()->can('payment-approve')){
                        $action.='<button data-id-id="'.$post->pId.'" type="button" class="btn btn-sm  btn-primary approved" style="-webkit-transform: scale(1);">Approve </button>';
                    }
                    if (auth()->user()->can('payment-verify')){
                        $action.='<button data-id="'.$post->pId.'" data-status="1" type="button" class="btn btn-sm  btn-primary verify" style="-webkit-transform: scale(1);">Un verify</button>';
                    }
                }
            }else{
                $action = '<span style="width: 100%; display: block" class="label label-danger">Deleted</span>';
            }

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if ($post->employeeDeletedAt==null && $post->companyDeletedAt==null && $post->projectDeletedAt==null) {

                if (($post->pStatus == 2 || $post->pStatus == 3 ) && auth()->user()->can('payment-edit') && auth()->user()->hasRole('superadmin')) {
                    $button .= '<li class="dropdown-item"> <a href="/payment/edit/' . $post->pId . '"> <i class="feather icon-edit"></i> Edit</a></li>';
                }
                if ($post->pStatus == 1 && auth()->user()->can('payment-edit')) {
                    $button .= '<li class="dropdown-item"> <a href="/payment/edit/' . $post->pId . '"> <i class="feather icon-edit"></i> Edit</a></li>';
                }
                if ($post->pStatus < 2 && auth()->user()->can('payment-delete')) {
                    $button .= '<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/payment/delete/' . $post->pId . '" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
                }
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

    private function checkAuthUserProjects($payment){
        $creatorUserProjects = auth()->user()->projects;
        $creatorUserData = array();
        if($creatorUserProjects){
            foreach ($creatorUserProjects as $creatorUserProject){
                $creatorUserData[$creatorUserProject->id]=$creatorUserProject->p_name;
            }
        }
        if (array_key_exists($payment->project_id, $creatorUserData)){
            return true;
        }
        return false;
    }

}
