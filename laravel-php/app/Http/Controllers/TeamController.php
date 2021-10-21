<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Teams;
use mysql_xdevapi\Exception;

class TeamController extends Controller
{

    public function index()
    {
        try {


            $items = Teams::with('projects', 'employees.role')->get();

            if ($items) {
                return response()->json([
                    'data' => $items
                ], 200);
            }
            return response()->json([
                'item' => "empty"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    //
    function addTeam(Request $req)
    {

        try {
            $req->validate([
                'name' => 'required|unique:teams'
            ]);
            $team = new Teams;
            $team->name = $req->input('name');
            $team->save();
            return $team;
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    function delete($id)
    {
        try {
            $result = Teams::where('id', $id)->first();
            $employee = Employee::where('team_id', $id)->first();
            if ($result) {
                if ($employee) {
                    return response()->json([
                        'message' => 'Can not delete team while there are employees in it.'
                    ], 500);
                } else {
                    $result = Teams::where('id', $id)->delete();
                    return response()->json([
                        'message' => 'Team deleted succesfully.'
                    ], 201);
                }
            } else {
                return response()->json([
                    'message' => 'unable to delete team.'
                ], 404);
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    function getTeam($id)
    {
        //        return Teams::find($id);
        try {


            $items = Teams::with('projects', 'employees.role')->find($id);

            if ($items) {
                return response()->json([
                    'data' => $items
                ], 200);
            }
            return response()->json([
                'item' => "empty"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    function search($key)
    {
        return Teams::where('name', 'Like', "%$key%")->get();
    }

    function updateTeam($id, Request $req)
    {
        $team = Teams::find($id);
        $team->name = $req->input('name');

        $team->save();
        return $team;
    }
}
