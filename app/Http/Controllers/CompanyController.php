<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:comp_profile', ['only' => ['index','create','store']]);

    }

    public function create(){

        return view('company.company');
    }

    public function index(){

        $company=Company::withTrashed()->get();
        return view('company.chome')->with('companys' ,$company);
    }

    public function store(Request $request){

        //dd('ok');

        $this->validate($request, [
            'name' => ['required', 'unique:companies'],
            'code' => ['required', 'unique:companies'],
        ]);


        $company =new Company;
        $company->name=$request->name;
        $company->code=$request->code;
        $company->c_email=$request->c_email;
        $company->c_mobile=$request->c_mobile;
        $company->c_address=$request->c_address;

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

        $this->validate($request, [
            "name" => 'required|unique:companies,name,'.$id,
        ]);

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

        if(auth()->user()->hasRole('superadmin')){
            $company->delete();
            return redirect()->route('comp_profile')->with('success','Company deleted successfully.');
        }

        return redirect()->route('comp_profile')->with('error','Error! This are not permitted.');

    }

    public function companyRestore($id){
        Company::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('comp_profile')->with('success','Company restored successfully');
    }




}
