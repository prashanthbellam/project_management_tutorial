<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaster extends Model
{
    protected $table = 'project_masters';

    protected $fillable = [
        'name',
        'details',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
