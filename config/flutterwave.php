<?php

return [

    /**
     * Public Key From Paystack Dashboard
     *
     */
    'publicKey' => env('FLUTTERWAVE_PUBLIC_KEY'),

    /**
     * Secret Key From Paystack Dashboard
     *
     */
    'secretKey' => env('FLUTTERWAVE_SECRET_KEY'),

    /**
     * Paystack Payment URL
     *
     */
    'paymentUrl' => env('FLUTTERWAVE_PAYMENT_URL'),

    /**
     * Optional email address of the merchant
     *
     */
    'merchantEmail' => env('MERCHANT_EMAIL'),

];
