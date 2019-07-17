<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Company;



class ProjectController extends Controller
{
    public function index(){

        $projects=Project::all();
      //  return view('project.project')->with('projects',$projects);
        return view('project.project',['projects'=>$projects]);

        }

    public function create(){

        $companies=Company::all();
        $projects=Project::all();
        return view('project.project_create',['companies'=>$companies,'project'=>$projects]);

    }


    public function store(Request $request){

        $this->validate(request(), [
            'project Name' => 'required',
            'project Title ' => 'required',


        ]);


        $project=new Project;
        $project->p_name=$request->p_name;
        $project->p_title=$request->p_title;
        $project->company_id=$request->company_id;


        $project->save();


        return redirect()->route('project');

    }



    public function __construct()
    {
        $this->middleware('auth');
    }


}
