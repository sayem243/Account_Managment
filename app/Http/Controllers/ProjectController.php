<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){

        return view('project.project');

        }

    public function create(){

        return view('project_create');


    }

}
