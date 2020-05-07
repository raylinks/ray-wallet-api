<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface PaymentInterface
{
    public function getAccountName(string $account_number, string $bank_code);

    //public function DepositSuccess(Request $request);
    // public function DepositWebHook();


}
