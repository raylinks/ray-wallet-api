<?php

namespace App\Services;

use App\Models\Ref;
use Illuminate\Database\Eloquent\Model;
use  GuzzleHttp\Client;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Paystack
{

    const VS = 'Verification successful';
    const ITF = 'Invalid transaction reference';


    protected $secretKey;

    /**
     * Instance of Client
     * @var Client
     */
    protected $client;

    /**
     *  Response from requests made to Paystack
     * @var mixed
     */
    protected $response;



    protected $baseUrl;

    protected $authorizationUrl;


    public function __construct()
    {
        $this->setKey();
        $this->setBaseUrl();
        $this->setRequestOptions();
    }

    /**
     * Get Base Url from Paystack config file
     */
    public function setBaseUrl()
    {
        $this->baseUrl = config('paystack.paymentUrl');
    }

    /**
     * Get secret key from Paystack config file
     */
    public function setKey()
    {
        $this->secretKey = config('paystack.secretKey');
    }


    private function setRequestOptions()
    {
        $authBearer = 'Bearer ' . $this->secretKey;

        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Authorization' => $authBearer,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ]
            ]
        );
    }


    private function setHttpResponse($relativeUrl, $method, $body = [])
    {
        if (is_null($method)) {
            throw new Exception("Empty method not allowed");
        }

        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl . $relativeUrl,
            ["body" => json_encode($body)]
        );

        return $this;
    }
    private function getResponse()
    {

        return json_decode($this->response->getBody(), true);
    }

    public function generateRef()
    {
        $ref = uniqid();

        // Ensure that the reference has not been used previously
        $validator = Validator::make(['ref' => $ref], ['ref' => 'unique:refs,val']);

        if ($validator->fails()) {
            return $this->generateRef();
        }

        return $ref;
    }

        public function getAuthorizationUrl()
    {
        $this->makePaymentRequest();

        $this->url = $this->getResponse()['data']['authorization_url'];
        //dd($this->url);
        return $this;
    }

    /**
     * Initiate a payment request to Paystack
     * @return Paystack
     */
    public function makePaymentRequest()
    {

        // $user = Auth::id();
        // dd($user);
        $ref = $this->generateRef();
        Ref::create([
            'user_id' => 1,
            'val' => $ref . time(),
            'amount' => request()->amount,
        ]);
        $data = [
            "amount" => intval(request()->amount * 100),
            "reference" => $ref . time(),
            "email" => "wife23@gmail.com",
            "callback_url" => request()->callback_url,
            'metadata' => request()->metadata,
        ];

        $data['metadata']['user_id'] = 2;

        // Remove the fields which were not sent (value would be null)
        array_filter($data);

        $this->setHttpResponse('/transaction/initialize', 'POST', $data);

        return $this;
    }

    private function verifyTransactionAtGateway()
    {
        $transactionRef = request()->reference;

        $relativeUrl = "/transaction/verify/{$transactionRef}";

        $this->response = $this->client->get($this->baseUrl . $relativeUrl, []);
    }

    /**
     * True or false condition whether the transaction is verified
     * @return boolean
     */
    public function isTransactionVerificationValid()
    {
        $this->verifyTransactionAtGateway();

        $result = $this->getResponse()['message'];

        switch ($result) {
            case self::VS:
                $validate = true;
                break;
            case self::ITF:
                $validate = false;
                break;
            default:
                $validate = false;
                break;
        }

        return $validate;
    }

    /**
     * Get Payment details if the transaction was verified successfully
     * @return json
     * @throws PaymentVerificationFailedException
     */
    public function getPaymentData()
    {
        if ($this->isTransactionVerificationValid()) {
            dd($this->getResponse());
            return $this->getResponse();
        } else {
            throw new PaymentVerificationFailedException("Invalid Transaction Reference");
        }
    }

}
