<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = ['id', 'user_id', 'post_id'];

    public function post()
    {
        return $this->belongsTo('\App\Models\Post');
    }


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
