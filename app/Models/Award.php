<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillale = ['user_id', 'title', 'issuer', 'url', 'date'];
}
