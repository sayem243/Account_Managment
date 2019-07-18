<?php

namespace App\Http\Controllers;

use App\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index(){
        $subtype= UserType::all();
        return view('usertype.u_index')->with('subtypes',$subtype);
    }

    public function create(){

        $subtype= UserType::all();

        return view('usertype.u_create');
    }

    public function store(Request $request){
//        dump($request);die;

        $user_type=new UserType;
        $user_type->u_title=$request->u_title;
        $user_type->status=1;

        $user_type->save();


        return redirect()->route('usertype');
    }

}


