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


        $date = $request->input('filter_date');
        $company_id = $request->input('filter_company_id');
        $companies = Company::all();
        $allCompanies = $companies;
        if ($company_id){
            $companies = DB::table('companies')->where('id', $company_id)->get();
        }
        $returnCompany = array();
        foreach ($companies as $company){
            $returnCompany[$company->id]= $company->name;
        }

        $returnAllCompanies = array();
        foreach ($allCompanies as $company){
            $returnAllCompanies[$company->id]= $company->name;
        }

        $users = User::all();

        $returnUser = array();

        foreach ($users as $user){
            $returnUser[$user->id]= $user->name;
        }

        $from_date = $date? $date.' 00:00:00': date('Y-m-d').' 00:00:00';
        $to_date = $date? $date.' 23:59:59': date('Y-m-d').' 23:59:59';
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

        $openingBalanceTotal = 0;

        $openingBalance=$this->getDailyOpeningBalance($from_date,$to_date,$company_id);

        foreach ($openingBalance as $value){
            $openingBalanceTotal+= $value->opening_balance;
        }

        foreach ($result as $cashTransaction){
            $returnArray[$cashTransaction->company_id][$cashTransaction->transaction_type][]=$cashTransaction;
        }

//        EOD method
        $getPreviousCurrentSessionClose = $this->getPreviousCurrentSessionClose($date?$date:date('Y-m-d'));

        return view('daily_cash_balance.index',
            ['openingBalance'=>$openingBalance, 'openingBalanceTotal'=>$openingBalanceTotal,
                'cashTransactions'=>$returnArray, 'companies'=>$returnAllCompanies,
                'company'=>$returnCompany, 'user'=>$returnUser,
                'getPreviousCurrentSessionClose'=>$getPreviousCurrentSessionClose,
                'selected_date'=>$date?$date:date('Y-m-d')]);


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

    public function getPreviousCurrentSessionClose($date){
        $cash_daily_balance_sessions = DB::table('cash_daily_balance_sessions')
            ->select('id')
            ->where('status',2)
            ->whereDate('created_at', '=', $date)
            ->get();

        if(sizeof($cash_daily_balance_sessions)>0){
            return false;
        }
        return true;
    }

}
