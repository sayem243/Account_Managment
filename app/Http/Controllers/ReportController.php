<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){

        $projects= Project::all();
        $paymentDetails=Payment_details::all();
        $details = array();

        foreach ($paymentDetails as $detail){
            $details[$detail->project->id][]  = $detail->paid_amount;
//            $detail[$detail->project->id][]= $detail->created_at;
        }

        return view('reports.index',['projects'=>$projects,'paymentDetails'=>$details]);
    }

}
