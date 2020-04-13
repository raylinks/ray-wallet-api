<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'name', 'contact_1','contact_2','note'
    ];
}
