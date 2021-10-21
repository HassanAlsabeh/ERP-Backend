<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','fname', 'lname', 'phonenum', 'email', 'team_id', 'role_id'];



    public function team()
    {
       return $this->belongsTo(Teams::class,'team_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id' , 'id');
    }



    public function kpis()
    {
        return $this->belongsToMany(KPIs::class, 'employee_kpis', 'employee_id', 'kpi_id');
    }


}
