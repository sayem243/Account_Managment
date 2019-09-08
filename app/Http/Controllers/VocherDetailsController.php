<?php

namespace App\Http\Controllers;

use App\Vocher_details;
use Illuminate\Http\Request;

class VocherDetailsController extends Controller
{
    public function index(){
        $details=Vocher_details::all();
        return view('voucher_details.index')->with('details',$details);
    }
}
