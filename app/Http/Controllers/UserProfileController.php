<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;

use App\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{


    public function index(){

        $profile= UserProfile::all();

        return view('profile.index',['profiles'=>$profile]);


    }



    public function create(){

        $companies=Company::all();
        $projects=Project::all();
        $userprofile=UserProfile::all();
        return view('profile.create',['companies'=>$companies,'project'=>$projects, '$userprofiles'=>$userprofile] );

    }


    public function store(Request $request){

        $profile= New UserProfile ;

        $profile->fname=$request->fname;
        $profile->lname=$request->lname;
        $profile->email=$request->email;
        $profile->mothername=$request->mothername;
        $profile->fathername=$request->fathername;
        $profile->p_address=$request->p_address;
        $profile->address=$request->address;


        $profile->joindate=$request->joindate;
        $profile->nid=$request->nid;
        $profile->mobile=$request->mobile;


        $user = User::create($profile);
        $user->assignRole($request->input('roles'));

        $profile->save();

        return redirect()->route('create');


    }





}
