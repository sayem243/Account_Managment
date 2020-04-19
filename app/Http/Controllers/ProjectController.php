<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Company;
use Spatie\Permission\Models\Role;



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

        $project=new Project;
        $project->p_name=$request->p_name;
        $project->company_id=$request->company_id;
        $project->address=$request->address;
        $project->save();

        return redirect()->route('project');

    }

    public function edit($id){

        $project=Project::find($id);
        $companies=Company::all();
        return view('project.project_edit',['project'=>$project ,'companies'=>$companies ]);

    }


    public function update(Request   $request ,$id){

        $project=Project::find($id);
        $project->p_name=$request->p_name;
        $project->address=$request->address;
        $project->company_id=$request->company_id;


        $project->save();


        return redirect()->route('project');


    }

    Public function delete($id){

        $project=Project::find($id);
        $project->delete();
        return redirect()->route('project');

    }


    public function __construct()
    {
        $this->middleware('auth');
    }


}
