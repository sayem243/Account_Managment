<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use Illuminate\Http\Request;
use Monolog\Formatter\ScalarFormatter;


class ReportController extends Controller
{
    public function index(){

        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();
        $date=Payment_details::all();

//        $users = DB::table('payment_details')
//            ->select(DB::raw('created_at, paid_amount'))
//            ->where('paid_amount', '=', '')
//            ->groupBy('paid_amount')
//            ->get();

        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
//            $detail[$detail->project->id][]= $detail->created_at;
        }

        return view('reports.index',['projects'=>$projects,'paymentDetails'=>$details ,'dates'=>$date]);
    }


    public function reportDate(){


        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();
        $date=Payment_details::all();


        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;

        }

        return view('reports.try',['projects'=>$projects,'paymentDetails'=>$details ,'dates'=>$date]);
    }



}
