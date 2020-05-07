<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    const NIGERIA = 1;

    protected $fillable = [
        'id', 'uuid', 'name', 'code', 'currency_code', 'dialing_code'
    ];

    protected $hidden = [
        'id', 'deleted_at', 'created_at', 'updated_at', 'type'
    ];
    public function user () {
        return $this->hasMany('App\User');
    }
}
