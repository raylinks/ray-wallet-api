<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Post extends Model
{
    protected $fillable = [
       'user_id', 'title','body', 'status'
    ];

     /**
      * Get all of the post's comments.
      */
     public function comments()
     {
         return $this->morphMany('App\Models\Comment', 'commentable');
     }

     public function likes()
     {
         return $this->hasMany(\App\Models\Like::class);
     }
 }
