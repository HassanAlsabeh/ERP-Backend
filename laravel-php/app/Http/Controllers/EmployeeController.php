<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\helper;

class EmployeeController extends Controller
{
    function index()
    {
        try {
            $items = Employee::with('kpis', 'team', 'role')->orderBy('fname', 'ASC')->get();
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

    function updateRole($id, Request $req)
    {
        $role = Employee::find($id);
        $role->role_id = $req->input('role_id');
        $role->save();
        return $role;
    }


    function addEmployee(Request $req)
    {
        try {
            $req->validate([
                'email' => 'required|unique:employees',
                'fname' => 'required',
                'lname' => 'required',
                'phonenum' => 'required|integer|unique:employees',
            ]);
            $employee_id = Helper::IDGenerator(new Employee, 'employee_id', 4,  date('ym'));
            $employee = new Employee;
            $employee->employee_id = $employee_id;
            $employee->fname = $req->input('fname');
            $employee->lname = $req->input('lname');
            $employee->email = $req->input('email');
            $employee->team_id = $req->input('team_id');
            $employee->phonenum = $req->input('phonenum');
            $employee->role_id = $req->input('role_id');
            $employee->file_path = $req->file('file_path')->store('products');
            if ($employee->save()) {
                return $employee;
            }
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function delete($id)
    {
        $result = Employee::where('id', $id)->delete();
        if ($result) {
            return ["result" => "Employee has been deleted"];
        } else {
            return ["result" => "Operation failed"];
        }
    }

    function getEmployee($id)
    {
        return Employee::with('team', 'role')->find($id);
    }



    function search($key)
    {
        return Employee::where('fname', 'Like', "%$key%")->get();
    }

    function updateEmployee($id, Request $req)
    {
        $employee = Employee::find($id);
        $employee->fname = $req->input('fname');
        $employee->lname = $req->input('lname');
        $employee->email = $req->input('email');
        $employee->team_id = $req->input('team_id');
        $employee->role_id = $req->input('role_id');
        $employee->phonenum = $req->input('phonenum');
        if ($req->file('file')) {
            $employee->file_path = $req->file('file')->store('products');
        }
        $employee->save();
        return $employee;
    }

    function removeTeam($id, Request $req)
    {
        $employee = Employee::find($id);
        $employee->team_id = $req->input('team_id');

        $employee->save();
        return $employee;
    }

    function updateOneEmployee($id, Request $req)
    {
        $employee = Employee::find($id);
        $employee->team_id = $req->input('team_id');
        $employee->save();
        return $employee;
    }

    function employeesUnassigned()
    {
        $data = Employee::where([['team_id', null]])->get();
        return $data;
    }
}
