<?php

namespace App\Http\Controllers;

use App\BankAndBranch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAndBranchController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');

    }

    public function indexBank(){
        return view('bank.index');
    }

    public function createBank(){
        return view('bank.add');
    }

    public function storeBank(Request $request){

        $this->validate($request, [

            'name' => ['required', 'unique:bank_and_branches'],
        ]);


        $bank =new BankAndBranch();
        $bank->name=$request->name;
        $bank->type="BANK";
        $bank->save();

        if($request->branch_name){
            foreach ($request->branch_name as $key=>$value){
                $branch =new BankAndBranch();
                $branch->name=$value;
                $branch->phone=$request->branch_phone[$key];
                $branch->email=$request->branch_email[$key];
                $branch->address=$request->branch_address[$key];
                $branch->bank_id=$bank->id;
                $branch->type="BRANCH";
                $branch->save();
            }
        }



        return redirect()->route('bank_index')->with('success','Bank has been successfully created.');
    }


    public function editBank($id){
        $bank=BankAndBranch::find($id);
        return view('bank.edit')->with('bank',$bank);
    }

    public function updateBank(Request $request, $id){

        $this->validate($request, [
            "name" => 'required|unique:bank_and_branches,name,'.$id
        ]);

        $bank = BankAndBranch::find($id);
        $bank->name=$request->name;
        $bank->type="BANK";
        $bank->save();


        if($request->branch_name){
            foreach ($request->branch_name as $key=>$value){
                if ($value!=''){
                    $branch =new BankAndBranch();
                    if(isset($request->branch_id[$key])){
                        $branch = BankAndBranch::find($request->branch_id[$key]);
                    }

                    $branch->name=$value;
                    $branch->phone=$request->branch_phone[$key];
                    $branch->email=$request->branch_email[$key];
                    $branch->address=$request->branch_address[$key];
                    $branch->bank_id=$bank->id;
                    $branch->type="BRANCH";
                    $branch->save();
                }
            }
        }

        return redirect()->route('bank_index')->with('success','Bank has been successfully Updated.');
    }

    public function deleteBank($id){
        $bank=BankAndBranch::find($id);
        $bank->delete();
        return redirect()->route('bank_index')->with('success','Bank has been successfully Updated.');
    }
    public function bankRestore($id){
        BankAndBranch::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('bank_index')->with('success','Bank has been successfully restored.');
    }

    public function dataTableBank(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('bank_and_branches');
        $countRecords->select('bank_and_branches.id as totalBank');
        $countRecords->where('bank_and_branches.type','=', "BANK");

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

        $rows = DB::table('bank_and_branches');
        $rows->select('bank_and_branches.id as bId','bank_and_branches.name as name','bank_and_branches.deleted_at as bankDeletedAt');
        $rows->where('bank_and_branches.type','=', "BANK");

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if (auth()->user()->can('superadmin')) {
                if ($post->bankDeletedAt==null){
                    $button .= '<li class="dropdown-item"><a href="/bank/edit/' . $post->bId . '"><i class="feather icon-eye"></i>Edit</a></li>';
                    $button .= '<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/bank/delete/' . $post->bId . '" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
                }else{
                    $button .= '<li class="dropdown-item"><a href="/bank/restore/' . $post->bId . '">
                                           <i class="fa fa-undo" aria-hidden="true"></i>
                                           Restore</a>
                                   </li>';
                }
            }
            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $name               = $post->name,
                $button,
                $status               = $post->bankDeletedAt,
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

//    Branch section start

    public function indexBranch(){
        return view('branch.index');
    }

    public function deleteBranch($id){
        $branch=BankAndBranch::find($id);
        $branch->delete();
        return new JsonResponse(['message'=>'Branch has been deleted.','status'=>200]);
    }
    public function branchRestore($id){
        BankAndBranch::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('bank_index')->with('success','Branch has been successfully restored.');
    }

    public function dataTableBranch(Request $request)
    {

        $query = $request->request->all();

        $countRecords = DB::table('bank_and_branches');
        $countRecords->select('bank_and_branches.id as totalBranch');
        $countRecords->where('bank_and_branches.type','=', "BRANCH");

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

        $rows = DB::table('bank_and_branches');
        $rows->select('bank_and_branches.id as bId','bank_and_branches.name as name','bank_and_branches.deleted_at as branchDeletedAt');
        $rows->where('bank_and_branches.type','=', "BRANCH");

        $rows->offset($iDisplayStart);
        $rows->limit($iDisplayLength);
        $rows->orderBy($columnName, $columnSortOrder);
//        $rows->groupBy('payment_details.payment_id');
        $result = $rows->get();

        $i = $iDisplayStart > 0 ? ($iDisplayStart + 1) : 1;

        foreach ($result as $post):

            $button = '<div class="btn-group card-option"><a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
            if (auth()->user()->can('superadmin')) {
                if ($post->branchDeletedAt==null){
                    $button .= '<li class="dropdown-item"><a href="/branch/edit/' . $post->bId . '"><i class="feather icon-eye"></i>Edit</a></li>';
                    $button .= '<li class="dropdown-item" ><a onclick="return confirm(\'Are you sure you want to delete this item\')" href = "/branch/delete/' . $post->bId . '" ><i class="feather icon-trash-2" ></i >Remove</a ></li >';
                }else{
                    $button .= '<li class="dropdown-item"><a href="/branch/restore/' . $post->bId . '">
                                           <i class="fa fa-undo" aria-hidden="true"></i>
                                           Restore</a>
                                   </li>';
                }
            }
            $button.='</ul></div>';

            $records["data"][] = array(
                $id                 = $i,
                $name               = $post->name,
                $button,
                $status               = $post->branchDeletedAt,
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
