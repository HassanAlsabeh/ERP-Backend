<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeKpi;
use App\Models\KPIs;
use Illuminate\Http\Request;

class KpisController extends Controller
{
    function store(Request $req)
    {
        try {
            $req->validate([
                'kpi_name' => 'required|unique:kpis',
            ]);
            $kpi = new KPIs();
            $kpi->kpi_name = $req->input('kpi_name');
            $kpi->save();
            if ($kpi->save()) {
                return $kpi;
            }
        } catch (\Throwable $e) {

            return response()->json([
                'message' => $e
            ], 500);
        }
    }



    function index()
    {
        try {
            $items = KPIs::get();

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

    function indexOfLast($id)
    {
        $KpiList = EmployeeKpi::where("employee_id", $id)->get();
        $kpi_names = EmployeeKpi::get('kpi_id');
      
        // dd($x);
        return $kpi_names;
    }
}
