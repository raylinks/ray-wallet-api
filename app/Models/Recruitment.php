<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Recruitment extends Model
{
    protected $fillable = [
       'user_id', 'job_title','is_paid','is_published', 'location', 'skills','experience','description','requirement','responsibility',
        'qualification','scope_of_work','closing_date'
    ];


     const PAID_STATUS = [
         'active' => 1,
         'inactive' => 0
     ];

 }
