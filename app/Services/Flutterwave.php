<?php

namespace App\Services;

use App\Interfaces\PaymentInterface;
use Illuminate\Http\Request;
use App\Logics\Deposit;
use App\Models\Deposit as DepositModel;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Ref;
use App\Helpers\Util;

class Flutterwave extends Service
{
    const TYPE = 'flutterwave';

    public function baseUri()
    {
        return config('flutterwave.paymentUrl');

    }

    public function retrivjson()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
    }

    public function generateRef()
    {
        $ref = uniqid();

        // Ensure that the reference has not been used previously
        $validator = \Validator::make(['ref' => $ref], ['ref' => 'unique:refs,val']);

        if ($validator->fails()) {
            return $this->generateRef();
        }

        return $ref;
    }
    /**
     * Redirect the User to Flutterwave Payment Page.
     * @ params amount
     * @return Url
     */
    public function FlutterwaveRedirectLink($redirect_callback)
    {
//        dd(config('flutterwave.paymentUrl'));
        $user = Auth::user();
        $protocol = Util::isRequestSecure() ? 'https://' : 'http://';
        $url = $protocol.rtrim($_SERVER['HTTP_HOST'], '/');
        $url .= '/verify/flutterwave/'.base64_encode($redirect_callback);

        $ref = $this->generateRef();
        Ref::create([
            'user_id' => 1,
            'val' => $ref,
            'amount' => request()->amount,
        ]);

        // Generate unique reference code
        do {
            $referenceCode = Str::orderedUuid();

        } while (!empty($code_avail));

        $trnx = Transaction::create([
            'uuid' => Str::orderedUuid(),
            'user_id' => auth()->id(),
            'reference_code' => $ref,
            'type' => 'fund_deposit',
            'status' => 'declined',
        ]);

        DepositModel::create([
            'user_id' => auth()->id(),
            'transaction_id' => $trnx->id,
            'deposit_type' => 'flutterwave',
            'deposit_amount' => request()->amount,
            'status' => 'declined',
            'reference_code' => $ref,
            //'flwref' => $flwref
        ]);

        $response = $this->post('/flwv3-pug/getpaidx/api/v2/hosted/pay', [
            'json' => [
                'amount' => request()->amount,
                'PBFPubKey' => config('flutterwave.publicKey'),
                'txref' => $ref,
                'redirect_url' => $url,
                'currency' => 'NGN',
                'meta' => ['user_id' => auth()->id()],
                'customer_email' => "ola@gmail.com",
                'customer_phone' => "09011111111",
            ],
        ]);

        return $response;
    }
    /**
     * verify flutterwave payment.
     *
     * @return JSON
     */
    public function verifyFlutterwavePayment(Request $request)
    {
        $userRef = Ref::where('val', $request->txref)->latest()->first();
        if ($userRef) {
            if ($userRef->status == 0) {
                try {
                    $ref = $userRef->val;
                    $amount = $userRef['amount'];
                    $currency = 'NGN';
                    $response = $this->post('/flwv3-pug/getpaidx/api/v2/verify', [
                        'json' => [
                            'SECKEY' => config('flutterwave.secretKey'),
                            'txref' => $ref,
                        ],
                    ]);
                    return $response;
                } catch (\Exception $e) {
                }
            }
        }
    }

    public function getAuthorizationUrl()
    {
        $this->makePaymentRequest();

        $this->url = $this->getResponse()['data']['authorization_url'];

        return $this;
    }

    public function makePaymentRequest()
    {
        $data = [
            'amount' => intval(request()->amount * 100),
            'reference' => time(),
            'email' => auth()->user()->email,
            'firstname' => request()->firstname,
            'lastname' => request()->lastname,
            'callback_url' => request()->callback_url,
            'metadata' => request()->metadata,
            'reference' => time(),
        ];

        $data['metadata']['user_id'] = auth()->user()->id;

        // Remove the fields which were not sent (value would be null)
        array_filter($data);

        $this->setHttpResponse('/transaction/initialize', 'POST', $data);

        return $this;
    }

    public function getResponse()
    {
        return json_decode($this->response->getBody(), true);
    }

    public function setHttpResponse($relativeUrl, $method, $body = [])
    {
        if (is_null($method)) {
            throw new Exception('Empty method not allowed');
        }

        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl.$relativeUrl,
            ['body' => json_encode($body)]
        );

        return $this;
    }

    /**
     * Verify the deposit transaction status on Flutterwave
     *
     * @param $reference
     * @return array
     */
    public function verifyDeposit($reference)
    {
        $base_url = $str = str_replace("v2/", "", config('flutterwave.paymentUrl'));

        $payload = [
            'json' => [
                "SECKEY" => config('flutterwave.secretKey'),
                "txref" => $reference
            ],
            'base_uri' => $base_url
        ];

        try
        {
            $response = $this->post('/flwv3-pug/getpaidx/api/v2/verify', $payload);

            if((data_get($response, 'data.data.status') == "successful") || (data_get($response, 'data.data.chargecode') == "00"))
            {
                return ["status" => true, "is_resolved" => true];
            }

            if((data_get($response, 'data.data.status') == "failed") || (data_get($response, 'data.data.chargecode') == "02"))
            {
                return ["status" => false, "is_resolved" => true];
            }

            return ["status" => false, "is_resolved" => false];
        }catch(\Exception $e)
        {
            return ["status" => false, "is_resolved" => false];
        }
    }

    public static function generateReferenceCode($class_name)
    {

        $class = new $class_name();
        $prefix = self::getPrefix($class_name);
        do {
            $reference_code = strtoupper($prefix . str_random(10));
            $code_avail = $class::where('reference_code', $reference_code)->first();
        } while (!empty($code_avail));

        return $reference_code;

    }
}
