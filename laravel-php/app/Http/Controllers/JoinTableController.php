<?php

namespace App\Http\Controllers;

use App\Models\EmployeeKpi;
use Illuminate\Http\Request;

class JoinTableController extends Controller
{
    public function index(){
        $data = EmployeeKpi::join('employees', 'employees.id' , '=' , 'employee_kpis.employee_id')
        ->join('kpis', 'kpis.id', '=' , 'employee_kpis.kpi_id')
        ->get(['employees.employee_id','latest', "kpi_name", 'rating' , 'kpi_id', 'employee_kpis.id']);

        return $data;
        // dd($data);
    }
}
