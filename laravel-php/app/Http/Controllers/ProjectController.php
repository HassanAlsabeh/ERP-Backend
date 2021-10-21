<?php

namespace App\Http\Controllers;

use App\Models\Project;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    //
    function addProject(Request $req)
    {

        try {
            $req->validate([
                'project_name' => 'required|unique:projects'
            ]);
            $project= new Project();
            $project->project_name=$req->input('project_name');
            $project->save();
            if($project->save()){
                return $project;
            }
        } catch (\Throwable $e) {

            return response()->json([
                'message'=>$e
            ],500);
        }
    }

    function list(){
        // return Project::all();
    try{
        $items = Project::with('team.employees')->get();
            if($items){
                return response()->json([
                    'data'=> $items
                ],200);
            }
            return response()->json([
                'item'=>"empty"
            ],404);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>$e
            ],500);
        }
    }

    function delete ($id){
        try{
            $result = Project::with('team')->where('id', $id)->first();
            if ($result) {
                if(count($result->team)>0){
                    return response()->json([
                        'message' => 'Can not delete project while there are teams in it.'
                    ],500);
                }else{
                    $result = Project::where('id', $id)->delete();
                    return response()->json([
                        'message' => 'Project deleted succesfully.'
                    ], 201);
                }
            } else {
                return response()->json([
                    'message' => 'unable to delete team.'
                ], 404);
            }
        }catch(\Exception $exception){
            return $exception->getMessage();
        }
    }

    function getProject($id){
        return Project::with('team')->find($id);
    }

    function search ($key){
        return Project::where('project_name','Like',"%$key%")->get();
    }

    function updateProject($id, Request $req ){
        $project= Project::find($id);
        $project->project_name=$req->input('project_name');
        $project->save();
        return $project;
    }

}
