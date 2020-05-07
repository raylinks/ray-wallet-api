<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


//use App\Models\Transaction\CryptoSale;

class Transaction extends Model
{

    protected $fillable = ['user_id', 'uuid', 'type', 'reference_code', 'status'];
    const TRANSACTION_BITCOIN = 'btc_transfer';
    const TRANSACTION_PAYPAL = 'paypal';

    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const CONFIRMED = 'confirmed';
    const DECLINED = 'declined';
    const SUCCESSFUL = 'successful';
}


