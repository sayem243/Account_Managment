<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 6/25/20
 * Time: 3:50 PM
 */

namespace App\Http\Controllers;


use App\Project;
use Illuminate\Http\JsonResponse;

class AjaxFunctionController
{
    public function getProjectsByCompany($companyId){
        $data=array();
        if ($companyId==0){
            $user = auth()->user();
            $projects=$user->projects;
            foreach ($projects as $project){
                $data[]= array('id'=>$project->id,'name'=>$project->p_name);
            }
            return new JsonResponse($data);
        }
        $projects = Project::withTrashed()->where('company_id', $companyId)->get();

        if($projects){
            foreach ($projects as $project){
                $data[]=array(
                    'id'=>$project->id,
                    'name'=>$project->p_name,
                );
            }
        }

        return new JsonResponse($data);
    }

    public function getUsersByProject($projectId){
        $data=array();
        if ($projectId==0){
            $user = auth()->user();
            $projects=$user->projects;
            foreach ($projects as $project){
                foreach ($project->users as $user){
                    $data[$user->id]= array('id'=>$user->id,'name'=>$user->name);
                }
            }
            return new JsonResponse($data);
        }
        $project= Project::withTrashed()->find($projectId);
        foreach ($project->users as $user){
            $data[$user->id]= array('id'=>$user->id,'name'=>$user->name);
        }


        return new JsonResponse($data);
    }

}