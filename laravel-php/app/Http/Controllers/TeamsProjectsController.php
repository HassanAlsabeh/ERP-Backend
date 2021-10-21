<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamsProjects;
use Illuminate\Support\Facades\Input;

class TeamsProjectsController extends Controller
{
    function index(){
        
    try{
        $items = TeamsProjects::get();
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

    public function store(Request $request){
        
        $table = new TeamsProjects();
        $table->fill($request->all());//because we used fillable
            if($table->save()){ //returns a boolean
                return response()->json([
                    'data'=> $table
                ],200);
            }
            else
            {
                return response()->json([
                    'team'=>'team could not be added' 
                ],500);
            }
        
        
    }
}
