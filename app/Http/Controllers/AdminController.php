<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
