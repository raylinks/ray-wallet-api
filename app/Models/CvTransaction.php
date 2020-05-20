<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvTransaction extends Model
{
    const NIGERIA = 1;

    protected $fillable = [
        'id','user_id', 'cvformat_id', 'cvpricing_id', 'status'
    ];

    protected $hidden = [
        'id', 'deleted_at', 'created_at', 'updated_at', 'type'
    ];
    public function cvformat () {
        return $this->belongsTo('App\CvFormat');
    }
}
