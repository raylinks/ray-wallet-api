<?php

namespace App\Logics;

use App\Models\Deposit as DepositModel;
use App\Models\User\UserCardDetail;
use Illuminate\Support\Str;

/**
 * undocumented class
 */
class Deposit extends GenericTransaction
{

    public function __construct($user) {
        $transaction_type = 'fund_deposit';
        $is_credit = true;
        parent::__construct($user, $transaction_type, $is_credit);
    }

    private function process($data) {
        DepositModel::create([
            //"uuid" => Str::orderedUuid(),
            "user_id" => $this->user->id,
            "transaction_id" => $this->transaction->id,
            "deposit_type" => "flutterwave",
            "deposit_amount" => $data['amount'],
            "status"        => "confirmed"
        ]);

        $response = $data['response'];

        UserCardDetail::create([
            //"uuid"      => Str::orderedUuid(),
            'user_id'   => $this->user->id,
            'auth'      => $response['data']['authorization']['authorization_code'],
            'last4'     => $response['data']['authorization']['last4'],
            'exp_month' => $response['data']['authorization']['exp_month'],
            'exp_yr'    => $response['data']['authorization']['exp_year'],
            'type'      => $response['data']['authorization']['brand'],
            'bank'      => $response['data']['authorization']['bank'],
        ]);
    }

    //amount must be in naira
    public function processTransaction($data) {
        $balance_history = $this->updateWallet($data['amount']);
        $this->updateWalletHistory($balance_history['previous_balance'], $balance_history['current_balance']);
        $this->process($data);
    }



}
