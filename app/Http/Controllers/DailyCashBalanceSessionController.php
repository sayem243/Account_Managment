<?php

namespace App\Http\Controllers;

use App\CashDailyBalanceSession;
use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyCashBalanceSessionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:daily-cash-balance-session', ['only' => ['index','generate','draftToConfirmStore','draftView','closingBalanceUpdate']]);

    }

    public function index(){

        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company->id;
        }

        $previousSessionOpen = $this->getSessionOpen();

        $rows = DB::table('cash_daily_balance_sessions');
        $rows->select('cash_daily_balance_sessions.id as sId','cash_daily_balance_sessions.created_at as createdDate', DB::raw('SUM(cash_daily_balance_sessions.opening_balance) as totalOpeningBalance'), DB::raw('SUM(cash_daily_balance_sessions.closing_balance) as totalClosingBalance'));
        $rows->whereIn('company_id', $userProjectCompany);
        $rows->groupBy('created_at');
        $rows->orderBy('created_at', 'ASC');

        $result = $rows->get();


            return view('daily_cash_balance_session.index',['cashBalanceSessions'=>$result, 'previousSessionOpen'=>$previousSessionOpen]);
//        return view('layout');
    }

    public function generate(Request $request){
        $submit = $request->generate;
//        $from_date =  date('Y-m-d').' 00:00:00';
        $date =  date('Y-m-d');
        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company;
        }
//        $companies = Company::all();
        $companies = $userProjectCompany;
        $insertId = array();
        if(isset($submit)){
            foreach ($companies as $company){

                $rows = DB::table('cash_daily_balance_sessions');
                $rows->where('company_id', $company->id);
                $rows->where('created_at','<', $date);
                $rows->limit(1);
                $rows->orderBy('id', 'DESC');
                $result = $rows->get();

                $existData = DB::table('cash_daily_balance_sessions');
                $existData->where('company_id', $company->id);
                $existData->where('created_at','=', $date);
                $existData->limit(2);
                $exResult = $existData->get();


                if (!isset($exResult[0])){
                    $dailyCashBalanceSession = new CashDailyBalanceSession();
                    $dailyCashBalanceSession->opening_balance = isset($result[0])? $result[0]->closing_balance:0;
                    $dailyCashBalanceSession->company_id = $company->id;
                    $dailyCashBalanceSession->created_at = $date;
                    $dailyCashBalanceSession->status = 0;
                    $dailyCashBalanceSession->save();
                    $insertId[]= $dailyCashBalanceSession->id;
                }
            }
        }
        if(!empty($insertId)){
            return redirect()->route('cash_balance_session_draft_view',http_build_query(['date'=>$date]))->with('success', 'Click save and confirm to generate opening balance.');
        }
        return redirect()->route('cash_balance_session_draft_view',http_build_query(['date'=>$date]))->with('error','Error! Today cash opening balance already generate.');
    }

    public function draftView(Request $request){
        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company->id;
        }
        $cashDailyBalanceSession = CashDailyBalanceSession::where('created_at','=', $request->date)->whereIn('company_id',$userProjectCompany)->get();

        return view('daily_cash_balance_session.draft',['cashDailyBalanceSessions'=>$cashDailyBalanceSession, 'requestDate'=>$request->date]);

    }
    public function draftToConfirmStore(Request $request)
    {
        $sessions_id = $request->session_id;
        $opening_balance = $request->opening_balance;

        foreach ($sessions_id as $key=>$value){
            $cashBalanceSession= CashDailyBalanceSession::find($value);
            $cashBalanceSession->opening_balance = $opening_balance[$key];
            $cashBalanceSession->status = 1;
            $cashBalanceSession->save();
        }
        return redirect()->route('opening_balance_session_list');
    }

    public function quickView(Request $request){

//        $companies = Company::all()->sortBy('name');
        $user = auth()->user();
        $projects=$user->projects;
        $returnCompany = array();
        foreach ($projects as $project){
            $returnCompany[$project->company->id]= $project->company->name;
        }

        $date = $request->input('filter_date');
        $company_id = $request->input('filter_company_id');

        $from_date = $date? $date.' 00:00:00': '';
        $to_date = $date? $date.' 23:59:59': '';
        $rows = DB::table('cash_transactions');
        if ($company_id!=''){
            $rows->where('company_id', $company_id);
        }
        $rows->whereIn('cash_transactions.transaction_via',[
            'CHECK_OUT',
            'INCOME_CASH',
            'INCOME_CHECK_CASH',
            'LOAN_CASH',
            'LOAN_CHECK_CASH',
            'HAND_SLIP_SETTLE',
            'HAND_SLIP_TRANSFER',
            'HAND_SLIP_CASH_RETURN',
            'HAND_SLIP_ISSUE',
            'VOUCHER',
        ]);
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $result = $rows->get();
        $returnArray = array();

        $openingBalance=$this->getDailyOpeningClosingBalance($from_date,$to_date,$company_id);

        foreach ($result as $cashTransaction){
            $returnArray[$cashTransaction->company_id][$cashTransaction->transaction_type][]=$cashTransaction->amount;
        }

        $returnHTML = view('daily_cash_balance_session.quick-view',['openingClosingBalance'=>$openingBalance, 'cashTransactions'=>$returnArray, 'companies'=>$returnCompany, 'selected_date'=>$date])->render();
        return response()->json( ['html'=>$returnHTML]);
    }

    public function getDailyOpeningClosingBalance($from_date,$to_date, $company_id){
        $rows = DB::table('cash_daily_balance_sessions');
        if ($company_id!=''){
            $rows->where('company_id', $company_id);
        }
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $rows->orderBy('id', 'ASC');
        $result = $rows->get();
        $returnData = array();

        foreach ($result as $value){
            $returnData[$value->company_id]=$value;
        }
        return $returnData;
    }


    public function closingBalanceUpdate(Request $request){
        $submit = $request->closing_update;
        $cash_balance_session_id = $request->cash_balance_session_id?$request->cash_balance_session_id:array();
        $selected_date = $request->selected_date;
        $date = isset($selected_date)?$selected_date: date('Y-m-d');

        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company;
        }
//        $companies = Company::all();
        $companies = $userProjectCompany;
        $insertId = array();
        if(isset($submit)){
            foreach ($companies as $company){

                $existData = DB::table('cash_daily_balance_sessions');
                $existData->where('company_id', $company->id);
                $existData->where('created_at','=', $date);
                $existData->limit(1);
                $exResult = $existData->get();


                if (isset($exResult[0])){
                    $dailyCashBalanceSession = CashDailyBalanceSession::find($exResult[0]->id);
                    if(array_key_exists($exResult[0]->id, $cash_balance_session_id)){
                        $dailyCashBalanceSession->closing_balance = isset($cash_balance_session_id[$dailyCashBalanceSession->id])?$cash_balance_session_id[$dailyCashBalanceSession->id]:$dailyCashBalanceSession->opening_balance;

                    }
                    $dailyCashBalanceSession->updated_at = new \DateTime();
                    $dailyCashBalanceSession->status = 2;
                    $dailyCashBalanceSession->save();
                    $insertId[]= $dailyCashBalanceSession->id;
                }
            }
        }
        if(!empty($insertId)){
            return redirect()->route('opening_balance_session_list')->with('success','Daily cash closing balance store successfully.');

        }
        return redirect()->route('opening_balance_session_list');
    }

    public function getSessionOpen(){

        $user = auth()->user();
        $projects=$user->projects;
        $userProjectCompany = array();
        foreach ($projects as $project){
            $userProjectCompany[$project->company->id]= $project->company->id;
        }

        $cash_daily_balance_sessions = DB::table('cash_daily_balance_sessions')
            ->select('id')
            ->where('status',1)
            ->whereDate('created_at', '<=', date('Y-m-d'))
            ->whereIn('company_id', $userProjectCompany)
            ->get();
        $cash_daily_balance_sessions_open = DB::table('cash_daily_balance_sessions')
            ->select('id')
            ->where('status',2)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->whereIn('company_id', $userProjectCompany)
            ->get();
        if(sizeof($cash_daily_balance_sessions)>0||sizeof($cash_daily_balance_sessions_open)>0){
            return false;
        }
        return true;
    }

}
