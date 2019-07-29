<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function create(){

        return view('company.company');
    }

    public function index(){

        $company=Company::all();
        return view('company.chome')->with('companys' ,$company);
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
        return redirect()->route('comp_profile');


    }

    public  function view($id){

        $company=Company::find($id);
        return view('company.view')->with('company' ,$company);
    }

    public  function edit($id){

        $company=Company::find($id);
        return view('company.edite')->with('company',$company);

    }



    public  function update(Request $request,$id){

        $company=Company::find($id);

        //$company =new Company;
        $company->name= $request->name;
        $company->c_email=$request->c_email;
        $company->c_mobile=$request->c_mobile;
        $company->c_address=$request->c_address;

        //image uploder


        if($request->hasFile('c_img')){

            $company->c_img=$request->c_img->store('public/images');
        }

        $company->save();
        return redirect()->route('comp_profile');

    }


    public function delete($id){

        $company=Company::find($id);

        $company->delete();

        return redirect()->route('comp_profile');

    }


    public function __construct()
    {
        $this->middleware('auth');
    }


}
