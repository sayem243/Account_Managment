<?php

namespace App\Http\Controllers;

use App\ExpenditureSector;
use App\Payment;
use App\Payment_details;
use App\Project;
use App\User;
use App\Vocher;
use App\Vocher_details;
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
        $this->middleware('permission:voucher_create', ['only' => ['create']]);


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
        $rows->addSelect('projects.p_name as projectName');
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

            $dropdown='<select name="expenditure_sector[]" class="form-control">
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
                $pId               = $post->pId,
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


    public function store(Request $request){
        $amount=$request->amount;
        $vocher=new Vocher();
        $vocher->total_amount=array_sum($amount);
        $vocher->user_id=$request->user_id;

        $vocher->comments=$request->comments;

        $vocher->save();
        $projects=$request->project_id;
        $payments=$request->payment_id;

        $file=$request->files->get('filenames');

        foreach ($payments as $key=>$payment){
            if($payment>0){
                $vocherDetails = new Vocher_details();
                $vocherDetails->project_id = $projects[$key];
                $vocherDetails->payment_id = $payment;
                $vocherDetails->amount = $amount[$key];

                if($request->hasFile('filenames')){
                if($file[$key]->getClientOriginalName()){
                    $filename = $file[$key]->getClientOriginalName();
                    $modifyFilename=time() . "_" .$filename;
                    $vocherDetails->filenames=$modifyFilename;
                    $file[$key]->move(public_path() . '/files/',$modifyFilename);
                }
                }

                $vocher->Vocher_details()->save($vocherDetails);
            }

        }
            $this->GenerateVocherId($vocher);


       return redirect()->route('voucher_index');
    }

    private function GenerateVocherId(Vocher $vocher){
        $datetime = new \DateTime("now");
        $sequentialId = sprintf("%s%s",$datetime->format('my'), str_pad($vocher->id,4, '0', STR_PAD_LEFT));
//        $generateCertificate = "V-{$sequentialId}";
        $vocher->voucher_id=$sequentialId;
        $vocher->save();
    }

    public static function paidAmountByPaymentAndProject($payment, $project){
        $paymentDetails = DB::table('payment_details')
            ->where([
                ['payment_id', '=', $payment],
                ['project_id', '=', $project],
            ])
            ->get();
        $data=array();
        if($paymentDetails){
            $amount=0;
            foreach ($paymentDetails as $paymentDetail){

                $amount+=$paymentDetail->paid_amount;
            }
           $data['amount']=$amount;
        }

        $amendmentDetails=DB::table('ammendments')->where([
            ['payment_id','=',$payment],
            ['project_id','=',$project],
        ])->get();

        $value=array();
        if($amendmentDetails){
            $tk=0;
            foreach ($amendmentDetails as $amendmentDetail){

                $tk+=$amendmentDetail->amendment_amount;
            }
            $value['tk']=$tk;
        }

        return  $amount+$value['tk'];
    }
    public function edit ($id){

        $vochers=Vocher::find($id);
        $users=User::all();
        $payments=Payment::all();


        return view('voucher.edit',['vochers'=>$vochers,'payments'=>$payments ,'users'=>$users]);

    }

    public function update(Request $request,$id){

        $vocher=Vocher::find($id);
        $amount=$request->amount;
        $newAmount=$request->amount?$request->amount:array(0);
        $exitAmount = $request->exit_amount?$request->exit_amount:array(0);
        $vocher->total_amount=array_sum($newAmount)+array_sum($exitAmount);
        $vocher->user_id=$request->user_id;
        $vocher->comments=$request->comments;
        $exit_amount=$request->exit_amount;

//        if($request->hasFile('file')){
//          $vocher->file=$request->file->store('/public/voucher');
//        }
        $vocher->save();
        $projects=$request->project_id;
        $payments=$request->payment_id;
        $exit_payment_details=$request->exit_payment_detail;
        $file=$request->files->get('filenames');

        if($payments){
            foreach ($payments as $key=>$payment){
                if($payment>0){
                    $vocherDetails = new Vocher_details();
                    $vocherDetails->project_id = $projects[$key];
                    $vocherDetails->payment_id = $payment;
                    $vocherDetails->amount = $amount[$key];

                    if($request->hasFile('filenames')){
                        if($file[$key]->getClientOriginalName()){
                            $filename = $file[$key]->getClientOriginalName();
                            $modifyFilename=time() . "_" .$filename;
                            $vocherDetails->filenames=$modifyFilename;
                            $file[$key]->move(public_path() . '/files/',$modifyFilename);
                        }
                    }

                    $vocher->Vocher_details()->save($vocherDetails);
                }
                }
            }
        if($exit_payment_details){
            foreach ($exit_payment_details as $key=>$detail){
              $vocherDetails=Vocher_details::find($detail);

              $vocherDetails->project_id=$request->exit_project_id[$key];
              $vocherDetails->payment_id=$request->exit_payment_id[$key];
              $vocherDetails->amount=$exit_amount[$key];

                    if($request->hasFile('filenames')){
                        if($file[$key]->getClientOriginalName()){
                            $filename=$file[$key]->getClientOriginalName();
                            $modifyFilename=time() ."_".$filename;
                            $vocherDetails->filenames=$modifyFilename;
                            $file[$key]->move(public_path() . '/files/',$modifyFilename);
                        }
                    }
                    $vocher->Vocher_details()->save($vocherDetails);
                }
             }

//        $this->GenerateVocherId($vocher);
        return redirect()->route('voucher_index');
    }

    public function  delete($id){
        $vocher=Vocher::find($id);
        $vocher->delete();
        return redirect()->route('voucher_index');
    }



    public function approved($id){
        $voucher=Vocher::find($id);
        $voucher->status=2;
        $voucher->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

}
