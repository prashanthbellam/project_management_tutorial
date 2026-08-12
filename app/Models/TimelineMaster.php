<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineMaster extends Model
{
    protected $table = 'timeline_masters';

    protected $fillable = [
        'stage',
        'responsibility',
        'is_micro',
        'is_major',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'is_micro' => 'boolean',
        'is_major' => 'boolean',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(TimelineMaster::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(TimelineMaster::class, 'parent_id');
    }
}
