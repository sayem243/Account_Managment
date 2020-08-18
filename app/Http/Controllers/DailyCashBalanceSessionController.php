<?php

namespace App\Http\Controllers;

use App\CashDailyBalanceSession;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyCashBalanceSessionController extends Controller
{
    public function index(){
        $rows = DB::table('cash_daily_balance_sessions');
        $rows->select('cash_daily_balance_sessions.id as sId','cash_daily_balance_sessions.created_at as createdDate', DB::raw('SUM(cash_daily_balance_sessions.opening_balance) as totalOpeningBalance'), DB::raw('SUM(cash_daily_balance_sessions.closing_balance) as totalClosingBalance'));
        $rows->groupBy('created_at');
        $rows->orderBy('created_at', 'ASC');

        $result = $rows->get();


            return view('daily_cash_balance_session.index',['cashBalanceSessions'=>$result]);
//        return view('layout');
    }

    public function generate(Request $request){
        $submit = $request->generate;
//        $from_date =  date('Y-m-d').' 00:00:00';
        $date =  date('Y-m-d');

        $companies = Company::all();
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
//            return redirect()->route('admin_index')->with('success','Daily cash opening balance generate successfully.');
            return redirect()->route('cash_balance_session_draft_view',http_build_query(['date'=>$date]))->with('success', 'Click save and confirm to generate opening balance.');


        }
        return redirect()->route('cash_balance_session_draft_view',http_build_query(['date'=>$date]))->with('error','Error! Today cash opening balance already generate.');
    }

    public function draftView(Request $request){
        $cashDailyBalanceSession = CashDailyBalanceSession::where('created_at','=', $request->date)->get();

        return view('daily_cash_balance_session.draft',['cashDailyBalanceSessions'=>$cashDailyBalanceSession]);

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

    public function closingBalanceUpdate(Request $request){
        $submit = $request->closing_update;
        $cash_balance_session_id = $request->cash_balance_session_id;
//        $from_date =  date('Y-m-d').' 00:00:00';
        $date =  date('Y-m-d');
//var_dump($cash_balance_session_id);die;
        $companies = Company::all();
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
                    $dailyCashBalanceSession->closing_balance = isset($cash_balance_session_id[$dailyCashBalanceSession->id])?$cash_balance_session_id[$dailyCashBalanceSession->id]:$dailyCashBalanceSession->opening_balance;
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

    public function __construct()
    {
        $this->middleware('auth');
    }


}
