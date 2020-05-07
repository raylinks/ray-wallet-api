<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    const STATUS_SENT = 'sent';
    const STATUS_RECEIVED = 'received';

    protected $table = 'wallet_histories';

    protected $fillable = [
        'uuid','transaction_id', 'current_balance', 'previous_balance', 'user_id',
        'status',
    ];

    public function wallet()
    {
        return $this->belongsTo(UserWallet::class);
    }

    public function walletable()
    {
        return $this->morphTo();
    }

    public static function map()
    {
        return [
            'card_sales'        => 'App\UserCardSalesTransaction',
            'fund_transfer'     => 'App\UserFundTransferTransaction',
            'fund_withdrawal'   => 'App\UserFundWithdrawal',
        ];
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
