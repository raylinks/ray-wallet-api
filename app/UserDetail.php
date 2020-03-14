<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id', 'username','title','firstname','lastname','date_of_birth','nationality','phone',
        'email','web', 'address',
        'profile','picture_url','interest'];
}
