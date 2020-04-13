<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
       'user_id', 'job_title', 'location', 'skills','experience','description','requirement','responsiility',
        'qualification','scope_of_work','closing_date'
    ];
}
