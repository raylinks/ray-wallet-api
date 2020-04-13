<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'job_title', 'country','city','time_from', 'time_to','currently_work', 'note'
    ];
}
