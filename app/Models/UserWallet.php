<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{

    protected $fillable = [
        'uuid', 'user_id', 'initial_amount', 'actual_amount', 'pm_account_no', 'btc_address'
    ];

    protected $hidden = [
        "id", "user_id", "created_at", "updated_at"
    ];

    protected $appends = ['flagged_amount', 'flagged_transaction_amount'];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }

    public function history()
    {
        return $this->hasMany('App\Models\Wallet\WalletHistory');
    }

    public function getFlaggedAmountAttribute()
    {
        return auth()->user()->amount;
    }

    public function getFlaggedTransactionAmountAttribute()
    {
        return (float) auth()->user()->transactionFlags()->flagged()->sum('amount');
    }
}
