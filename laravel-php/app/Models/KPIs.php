<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIs extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','kpi_name', 'kpi_rate'];
    protected $table = "kpis";


    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_kpis', 'kpi_id', 'employee_id');
    }

    public function employeekpi()
    {
        return $this->belongsTo(EmployeeKpi::class);
    }
}
