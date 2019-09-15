<?php

namespace App\Http\Controllers;

use App\Vocher;
use App\Vocher_details;
use Illuminate\Http\Request;

class VocherDetailsController extends Controller
{
    public function index($id){
        $details=Vocher::find($id);


        return view('voucher_details.index',['details'=>$details]);
    }


}

