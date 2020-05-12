<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvFormat extends Model
{
    const NIGERIA = 1;

    protected $fillable = [
        'id', 'name', 'image'
    ];

    protected $hidden = [
        'id', 'deleted_at', 'created_at', 'updated_at', 'type'
    ];
}
