<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TasksMaster extends Model
{
    protected $table = 'tasksMaster';

    protected $fillable = [
        'task',
        'task_details',
        'task_order',
    ];

    protected function casts(): array
    {
        return [
            'task_order' => 'integer',
            'is_deleted' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            TasksMaster::class,
            'parent_id'
        )->where('is_deleted', false);
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            TasksMaster::class,
            'parent_id'
        )->where('is_deleted', false);
    }
}
