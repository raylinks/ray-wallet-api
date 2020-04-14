<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = ['user_id', 'title', 'issuer', 'web_url', 'date'];
}
