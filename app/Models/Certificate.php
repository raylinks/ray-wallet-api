<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillale = ['user_id','name', 'authority', 'url', 'date'];
}
