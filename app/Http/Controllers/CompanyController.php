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


           // $img=time() .'.'. $c_img->getClientOriginalExtension();

//          $company->c_img = $request->c_img->store('/public/image');

//            $company=$request->file('c_img');
//            $img = time() . '.' . $company->getClientOriginalExtension();
//            $location = public_path('images/cImages'  .$img);
//            Company::make($company)->save($location);


            $company->c_img=$request->c_img->store('public/images');




        }



        $company->save();
        return redirect()->route('comp_create');



    }
}
