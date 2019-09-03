<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Project;
use Illuminate\Http\Request;

class VocherController extends Controller
{

    public function create(){

        $payments=Payment::all();
        $projects=Project::all();


        return  view('voucher.create',['payments'=>$payments,'projects'=>$projects]);
    }

}
