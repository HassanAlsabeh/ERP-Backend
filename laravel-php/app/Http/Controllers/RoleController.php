<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function index(){
        // return Project::all();
    try{
        $items = Roles::with('employee')->get();
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


    function store(Request $req)
    {
        $role= new Roles();
        $role->role_name=$req->input('role_name');
        $role->save();
        return $role;
    }
    function updateRole($id, Request $req)
    {
        $role = Roles::find($id);
        $role->role_name = $req->input('role_name');

        $role->save();
        return $role;
    }


    public function destroy($id)
    {
        $role = Roles::find($id);
        if($role->delete()){ //returns a boolean
            return response()->json([
                'admin'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'admin'=>'admin could not be deleted'
            ],500);
        }
    }
    public function getRole($id){
        return Roles::find($id);
    }

}
