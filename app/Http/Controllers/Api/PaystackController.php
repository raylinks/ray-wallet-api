<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Paystack;

class PaystackController extends Controller
{
    public function getLinkUrl()
    {
        $urlLink = new Paystack();
        $urlLink->getRaybaba();
    }

}
