<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Educate extends Model
{
    protected $fillable = [
        'user_id', 'institution', 'field_of_study', 'country','city','time_from', 'time_to','note'
    ];
}
