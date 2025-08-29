<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
   
    use HasFactory;
    
    protected $table = 'tasks';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'assign_to',
        'status',
        'priority',
    ];


    public function project() {
        return $this->belongsTo(Project::class);
    }

    
}
