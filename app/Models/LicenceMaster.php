<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenceMaster extends Model
{
    protected $table = 'licenceMaster';

    protected $fillable = [
        'name',
        'required_for',
        'created_by',
        'updated_by',
        'is_deleted',
        'deleted_at',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
    ];
}
