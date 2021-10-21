<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['project_name'];

    public function team()
    {
        return $this->belongsToMany(Teams::class, 'teams_projects', 'project_id', 'team_id');
    }


}
