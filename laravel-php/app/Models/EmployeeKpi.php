<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeKpi extends Model
{
    use HasFactory;

    protected $fillable =  ['kpi_id', 'employee_id', 'rating'];
    protected $table = 'employee_kpis';

    public function kpi()
    {
        return $this->belongsTo(KPIs::class);
    }
}
