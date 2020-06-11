<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;



class ProjectController extends Controller
{
    public function index(){

        $companies=Company::all()->sortBy('name');

        $rows = DB::table('projects');
        $rows->join('companies', 'projects.company_id', '=', 'companies.id');
        $rows->select( 'projects.id', 'projects.p_name as projectName');
        $rows->addSelect('companies.id as comId', 'companies.name as companyName');
        $rows->orderBy('projectName', 'Asc');
        $projects = $rows->get();
        $arrayData= array();
        foreach ($projects as $project){
            $arrayData[$project->comId][]= $project;
        }

        return view('project.project',['projects'=>$arrayData, 'companies'=>$companies]);

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
