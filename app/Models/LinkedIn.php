<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedIn extends Model
{
    protected $table = 'linked_ins';
    protected $fillable = [ 'user_id', 'url', 'image'];


}
