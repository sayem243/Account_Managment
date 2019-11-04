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


        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
//            $detail[$detail->project->id][]= $detail->created_at;
        }

        return view('reports.index',['projects'=>$projects,'paymentDetails'=>$details ,'dates'=>$date]);
    }

//use for testing
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


    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $formDate = date('Y-m-d', strtotime($request->from_date));
                $toDate = date('Y-m-d', strtotime($request->to_date));
                $data = DB::table('payment_details')
                    ->whereBetween('created_at', array($formDate.' 00:00:00', $toDate.' 23:59:59'))
                    ->get();
            }
            else
            {
                $data = DB::table('payment_details')->orderBy('created_at', 'ASC')->get();
            }
            $paymentDetails=array();
            foreach ($data as $value){
                $paymentDetails[$value->project_id][]= $value->paid_amount;
            }
            $projects= Project::all();
            $html = '<tr>';
            foreach ($projects as $project){
                $html.='<td>';
                if(array_key_exists($project->id, $paymentDetails)){
                    $html.='<table class="table table-bordered payment_report">';
                    foreach($paymentDetails[$project->id] as $paymentDetail){
                        $html.='<tr><td>'.$paymentDetail.'</td></tr>';
                    }
                    $html.='</table>';
                }
                $html.='</td>';

            }
            $html.='</tr>';
            echo $html;

        }
    }



}
