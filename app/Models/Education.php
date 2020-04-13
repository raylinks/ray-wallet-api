<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
       'user_id', 'institution', 'field_of_study', 'country','city','time_from', 'time_to','note'
    ];
}
