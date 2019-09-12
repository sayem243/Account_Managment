<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Payment_details;
use App\Project;
use Illuminate\Http\Request;

class PaymentDetailsController extends Controller
{

    Public function index($id){

        $payment=Payment::find($id);
        $projects=Project::find($id);


        return view('payment_details.index',['payment'=>$payment,'projects'=>$projects,]);

    }





}
