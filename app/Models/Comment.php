<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Comment extends Model
{
    protected $fillable = [
       'user_id', 'body','commentable_id', 'commentable_type','comments'
    ];


     /**
      * Get the owning commentable model.
      */
     public function commentable()
     {
         return $this->morphTo();
     }
 }


