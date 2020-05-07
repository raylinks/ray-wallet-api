<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    protected $fillable = ['user_id','transaction_id', 'deposit_type', 'deposit_amount','status','reference_code'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
