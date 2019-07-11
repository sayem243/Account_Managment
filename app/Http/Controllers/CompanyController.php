<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function create(){

        return view('company');
    }

    public function index(){

        $company=Company::all();
        return view('chome')->with('companys' ,$company);
    }




    public function store(Request $request){

        //dd('ok');

        $this->validate($request, [

            'image' => 'nullable|image'
        ]);


        $company =new Company;

        $company->name=$request->name;
        $company->c_email=$request->c_email;
        $company->c_mobile=$request->c_mobile;
        $company->c_address=$request->c_address;

        //image uploder


        if($request->hasFile('c_img')){



            $company->c_img=$request->c_img->store('public/images');


        }

        $company->save();
        return redirect()->route('comp_create');


    }

    public  function view($id){

        $company=Company::find($id);
        return view('view')->with('company' ,$company);


    }


    public function __construct()
    {
        $this->middleware('auth');
    }


}
