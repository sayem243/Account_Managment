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

    public function dailyCashBalance(){

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

        $from_date = date('Y-m-d').' 00:00:00';
        $to_date = date('Y-m-d').' 23:59:59';
        $rows = DB::table('cash_transactions');
//        $rows->where('cash_transactions.transaction_type','=', 'CR');
        $rows->whereBetween('created_at', [$from_date, $to_date]);
        $result = $rows->get();
        $returnArray = array();

        foreach ($result as $cashTransaction){
            $returnArray[$cashTransaction->company_id][$cashTransaction->transaction_type][]=$cashTransaction;
        }
        return view('daily_cash_balance.index',['cashTransactions'=>$returnArray, 'company'=>$returnCompany, 'user'=>$returnUser]);


    }

}
