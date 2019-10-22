<?php

namespace App\Http\Controllers;

use App\Payment_details;
use App\Project;
use Illuminate\Http\Request;
use DB;


class DateRangeController extends Controller
{

    function index()
    {
        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();

//        $datas = DB::select(' SELECT SUM(paid_amount), project_id as project , DATE(updated_at) DateOnly FROM payment_details GROUP BY DateOnly,project');
//        var_dump($datas);
//
//        exit;


        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
        }


        return view('reports.date_range',['projects'=>$projects,'paymentDetails'=>$details ]);
    }


    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $data = DB::table('payment_details')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->get();
            }
            else
            {
                $data = DB::table('payment_details')->orderBy('created_at', 'desc')->get();
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









//edit

    function fetch_data_value(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $data = DB::table('payment_details')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->get();
            }
            else
            {
                $data = DB::table('payment_details')->orderBy('created_at', 'desc')->get();
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
