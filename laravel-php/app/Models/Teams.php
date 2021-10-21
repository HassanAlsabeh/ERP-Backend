<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'team_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'teams_projects', 'team_id', 'project_id');
    }
}
