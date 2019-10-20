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
            echo json_encode($data);
        }
    }


}
