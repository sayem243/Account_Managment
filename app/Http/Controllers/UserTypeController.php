<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index(){

        return view('usertype.u_index');
    }

    public function create(){

        return view('usertype.u_create');
    }

}


