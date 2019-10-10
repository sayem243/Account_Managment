<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){

        $projects= Project::all();
        $payments=Payment::all();

        $paymentDetails=Payment::all();

        return view('reports.index',['projects'=>$projects,'payments'=>$payments,'paymentDetails'=>$paymentDetails]);

    }



}
