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
       if(auth()->user()->hasRole('Employee')){
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
//        $demand_amount=$request->demand_amount;
        $paid_amount=$request->paid_amount;
        $userProfile = UserProfile::where('user_id', $request->user_id)->get();


        $payment=new Payment();
        $payment->user_id=$request->user_id;
        $payment->comments=$request->comments;
        $payment->company_id=$userProfile[0]->company_id;
        $payment->total_demand_amount=array_sum($paid_amount);
        $payment->total_paid_amount=array_sum($paid_amount);
        $payment->created_by=$user->id;

        $file = $request->files->get('filenames');
        $payment->save();
        $projects=$request->project_id;
        $itemName=$request->item_name;
       // $file=$request->filenames;
        foreach ($projects as $key => $project){
            if($project>0){
                $paymentDetails = new Payment_details();
                $paymentDetails->project_id=$project;
                $paymentDetails->item_name=$itemName[$key];
                $paymentDetails->demand_amount=$paid_amount[$key];
                $paymentDetails->paid_amount=$paid_amount[$key];

                /*multiple file upload*/

                /*if($request->hasFile('filenames')){
                   if ($file[$key]->getClientOriginalName()) {
                       $filename = $file[$key]->getClientOriginalName();
                       $modifyFilename = time() . "_" . $filename;
                       $paymentDetails->filenames = $modifyFilename;
                       $file[$key]->move(public_path() . '/files/', $modifyFilename);
                   }
                }*/
                   $payment->Payment_details()->save($paymentDetails);

            }
        }

             $this->GeneratePaymentId($payment);

        return redirect()->route('payment')->with('success', 'Post has been successfully submitted pending for approval');

    }

    private function GeneratePaymentId(Payment $payment){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($payment->id,4, '0', STR_PAD_LEFT));

        $payment->payment_id=$sequentialId;
        $payment->save();
    }



    public function printPDF($id){

        $user=Payment::find($id);
        $pdf = PDF::loadView('payment.pdf_view', compact('user',$id));
        return $pdf->download('payment.pdf');

    }

    public function edite($id){

        //$payment = \DB::table('payments')->where('id', $id)->first();
        $payment=Payment::find($id);
        $companies=Company::all();
        $user=User::all();
        $project=Project::all();
        $paymentDetails=Payment_details::all();

        return view('payment.edite',['payment'=>$payment ,'companies'=>$companies ,'users'=>$user,'project'=>$project ,'paymentDetails'=>$paymentDetails]);

    }


    public function update(Request $request,$id){

        $payment=Payment::find($id);
        $user = auth()->user();
        $userProfile = UserProfile::where('user_id', $request->user_id)->get();
        //Now demand amount not used.
//        $demand_amount=$request->demand_amount?$request->demand_amount:array(0);
        $paid_amount=$request->paid_amount?$request->paid_amount:array(0);
//        $exit_demand_amount=$request->exit_demand_amount?$request->exit_demand_amount:array(0);
        $exit_paid_amount=$request->exit_paid_amount?$request->exit_paid_amount:array(0);
        $payment->user_id=$request->user_id;
        $payment->company_id=$userProfile[0]->company_id;
        $payment->comments=$request->comments;

        $payment->total_demand_amount=(array_sum($paid_amount)+array_sum($exit_paid_amount));

        $payment->total_paid_amount=(array_sum($paid_amount)+array_sum($exit_paid_amount));

        $payment->created_by=$user->id;
        $payment->save();
        $projects=$request->project_id;
        $itemName=$request->item_name;

        if($projects){
            foreach ($projects as $key=>$project){
                if($project>0){
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
        return redirect()->route('payment');
    }
    //verify
    public function verify(Request $request, $id){
        $user = auth()->user();
        $status = $request->post('payment_status');
        $payment=Payment::find($id);
        $payment->status=$status;
        $payment->verified_by=$user->id;
        $payment->verified_at= new \DateTime();
        //$payment->status=2;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

    //approved by
    public function approve($id){
        $user = auth()->user();
        $payment=Payment::find($id);
        //$payment->status=1;
        $payment->approved_by=$user->id;
        $payment->approved_at= new \DateTime();
        $payment->status=3;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>100]);
    }
    public function payment_paid($id){
        $user = auth()->user();
        $payment=Payment::find($id);
        //$payment->status=1;
        $payment->status=4;
        $payment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>100]);
    }

//    public function details($id){
//
//        $payment=Payment::find($id);
//        $amendment = $payment->ammendment;
//        $total=$amendment->sum('additional_amount');
//        return view('payment.details',['payment'=>$payment, 'total'=>$total]);
//    }

       public function  Voucher($id){

       $payment=Payment::find($id);
       $amendment = $payment->ammendment;
       $total=$amendment->sum('additional_amount');
       return view('voucher.index',['payment'=>$payment,'total'=>$total]);
    }

    public function delete($id){
        $payment=Payment::find($id);
        $payment->delete();
        return redirect()->route('payment');
    }

    public function dataTable(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('payments');
        $countRecords->select(DB::raw('count(*) as totalPayment'));
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $countRecords->where('payments.payment_id', 'like', "{$name}%");
        }

        /*if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $countRecords->where('payments.company_id',$company_id);
        }*/
        if (isset($query['user_id'])) {
            $user_id = $query['user_id'];
            $countRecords->where('payments.user_id', $user_id);
        }

        $tcount = $countRecords->first();
        $iTotalRecords = $tcount->totalPayment;
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
        $rows->join('user_profiles', 'employee.id', '=', 'user_profiles.user_id');
        $rows->join('companies', 'user_profiles.company_id', '=', 'companies.id');
        $rows->select('payments.id as pId', 'payments.payment_id as name', 'payments.total_paid_amount as amount', 'payments.status as pStatus', 'payments.created_at as created_at', 'payments.verified_by as paymentVerifyBy');
        $rows->addSelect('companies.name as companyName');
        $rows->addSelect('employee.name as employeeName');
        $rows->addSelect('createdBy.name as creatorName');
        if (isset($query['payment_id'])) {
            $name = $query['payment_id'];
            $rows->where('payments.payment_id', 'like', "{$name}%");
        }


        /*if(isset($query['company_id'])){
            $company_id = $query['company_id'];
            $rows->where('payments.company_id',$company_id);
        }*/
        if (isset($query['user_id'])) {
            $user_id = $query['user_id'];
            $rows->where('payments.user_id', $user_id);
        }

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):
            $paymentStatus = '';
            if ($post->pStatus == 1 && $post->paymentVerifyBy == null) {
                $paymentStatus = '<span class="label label-primary">Created</span>';
            } elseif ($post->pStatus == 1 && $post->paymentVerifyBy != null) {
                $paymentStatus = '<span class="label label-primary">Un verified</span>';
            } elseif ($post->pStatus == 2) {
                $paymentStatus = '<span class="label label-warning">Verified</span>';
            } elseif ($post->pStatus == 3) {
                $paymentStatus = '<span class="label label-success">Approved</span>';
            } elseif ($post->pStatus == 4) {
                $paymentStatus = '<span class="label label-info">Disbursed</span>';
            }

            $action='';
            if($post->pStatus==1 && auth()->user()->can('payment-verify')){
                $action.='<button data-id="'.$post->pId.'" data-status="2" type="button" class="btn btn-sm  btn-primary verify">Verify </button>';
            }elseif($post->pStatus==2){
                if (auth()->user()->can('payment-approve')){
                    $action.='<button data-id-id="'.$post->pId.'" type="button" class="btn btn-sm  btn-primary approved">Approve </button>';
                }
                if (auth()->user()->can('payment-verify')){
                    $action.='<button data-id="'.$post->pId.'" data-status="1" type="button" class="btn btn-sm  btn-primary verify">Un verify</button>';
                }
            }elseif($post->pStatus==3 && auth()->user()->can('payment-verify')){
                $action.='<button data-id-id="'.$post->pId.'" type="button" class="btn btn-sm btn-success payment_paid">Disburse</button>';
            }

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if ($post->pStatus == 1 && auth()->user()->can('payment-edit')) {
                $button .= '<li class="dropdown-item"> <a href="/payment/edit/'.$post->pId.'"> <i class="feather icon-edit"></i> Edit</a></li>';
            }
            if ($post->pStatus < 4 && auth()->user()->can('payment-delete')) {
                $button .='<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/payment/delete/'.$post->pId.'" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
            }

            $button .='<li class="dropdown-item"><a href="/payment/details/'.$post->pId.'"><i class="feather icon-eye"></i>Details</a></li>';

            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $createdAt          = date('d-m-Y',strtotime($post->created_at)),
                $name               = $post->name,
                $employeeName       = $post->employeeName,
                $companyName        = $post->companyName?$post->companyName:'',
                $amount             = $post->amount,
                $creatorName        = $post->creatorName,
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
