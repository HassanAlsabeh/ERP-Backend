<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeKpiController extends Controller
{
    function store(Request $req)
    {
        $req->validate([
            'kpi_id' => 'required',
            'employee_id' => 'required|integer',
            'rating' => 'required|integer|between:0,10',
        ]);
        $kpi = new Employeekpi();
        $kpi->kpi_id = $req->input('kpi_id');
        $kpi->employee_id = $req->input('employee_id');
        $kpi->rating = $req->input('rating');
        $kpi->latest = 1;


        DB::table('employee_kpis')
            ->where([['kpi_id', $req->input('kpi_id')], ['employee_id', $req->input('employee_id')]])
            ->update(['latest' => 0]);
        $kpi->save();
        return $kpi;
    }

    public function index()
    {
        try {
            $items = EmployeeKpi::get();
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
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function latestRatings($id){
        $kpi = EmployeeKpi::with('kpi')->where([['employee_id', $id], ['latest', 1]])->get();

        return $kpi;
    }

    public function getLastFive($id, $kpi_id){

            $last = EmployeeKpi::where([['employee_id', $id],['kpi_id', $kpi_id]])->orderBy('created_at', 'desc')->latest()->take(5)->get();
            return response()->json([
                'data' => $last
            ]);

    }
    public function getLastTen($id, $kpi_id){

        $last = EmployeeKpi::where([['employee_id', $id],['kpi_id', $kpi_id]])->orderBy('created_at', 'desc')->latest()->take(10)->get();
        return response()->json([
            'data' => $last
        ]);

    }



}
