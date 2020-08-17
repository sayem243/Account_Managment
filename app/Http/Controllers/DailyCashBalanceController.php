<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\Company;
use App\Payment;
use App\PaymentSettlement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyCashBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function dailyCashTransaction(Request $request){

        $companies = Company::all();
        $returnCompany = array();
        foreach ($companies as $company){
            $returnCompany[$company->id]= $company->name;
        }

        $users = User::all();

        $returnUser = array();

        foreach ($users as $user){
            $returnUser[$user->id]= $user->name;
        }
        $date = $request->input('filter_date');
        $company_id = $request->input('filter_company_id');

        $from_date = $date? $date.' 00:00:00': date('Y-m-d').' 00:00:00';
        $to_date = $date? $date.' 23:59:59': date('Y-m-d').' 23:59:59';
        $rows = DB::table('cash_transactions');
        if ($company_id!=''){
            $rows->where('company_id', $company_id);
        }
//        $rows->where('cash_transactions.transaction_type','=', 'CR');
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $result = $rows->get();
        $returnArray = array();

        $openingBalance=$this->getDailyOpeningBalance($from_date,$to_date,$company_id);

        foreach ($result as $cashTransaction){
            $returnArray[$cashTransaction->company_id][$cashTransaction->transaction_type][]=$cashTransaction;
        }
        return view('daily_cash_balance.index',['openingBalance'=>$openingBalance, 'cashTransactions'=>$returnArray, 'company'=>$returnCompany, 'user'=>$returnUser]);


    }

    public function getDailyOpeningBalance($from_date,$to_date, $company_id){
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

}
