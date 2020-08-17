<?php

namespace App\Http\Controllers;

use App\CashDailyBalanceSession;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        if(auth()->user()->can('check-registry-create')){
            return view('admin.dashboard');
        }
        return redirect()->route('payment');
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
                    $dailyCashBalanceSession->opening_balance = $result[0]->closing_balance;
                    $dailyCashBalanceSession->company_id = $company->id;
                    $dailyCashBalanceSession->created_at = $date;
                    $dailyCashBalanceSession->save();
                    $insertId[]= $dailyCashBalanceSession->id;
                }
            }
        }
        if(!empty($insertId)){
            return redirect()->route('admin_index')->with('success','Daily cash opening balance generate successfully.');

        }
        return redirect()->route('admin_index')->with('error','Error! Today cash opening balance already generate.');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }


}
