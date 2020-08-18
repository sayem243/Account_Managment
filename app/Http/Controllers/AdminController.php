<?php

namespace App\Http\Controllers;

use App\CashDailyBalanceSession;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){

        return redirect()->route('payment');
//        return view('layout');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }


}
