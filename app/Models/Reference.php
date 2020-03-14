<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'company_name', 'name', 'contact_1','contact_2','note'
    ];
}
