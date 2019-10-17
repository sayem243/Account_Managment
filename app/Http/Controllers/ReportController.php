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


    public function report(){

        $projects=Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();

        return view('reports.try',['projects'=>$projects,'paymentDetails'=>$paymentDetails]);
    }

    public function reportDate($date){
//
//        $report= Payment_details::find($date);
//        $details= DB::table('payment_details')
//            ->select(DB::raw('paid_amount','created_at'))
//            ->where('paid_amount')
//            ->get();


        $details=DB::table('payment_details')
                    ->select('created_at','paid_amount')->where('');
    }

}
