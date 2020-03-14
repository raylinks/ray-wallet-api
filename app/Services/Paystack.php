<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use  GuzzleHttp\Client;

class Paystack
{
    //protected $url= http://raybaba.com

        public function getRaybaba()
        {
            $client = new Client();

            $res = $client->request('POST', 'https://api.paystack.co/transaction/initialize', [

            ]);
            dd($res);
            echo $res->getStatusCode();
// "200"
            echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
            echo $res->getBody();
// {"type":"User"...'
        }

        public function postRaybaba()
        {

            $client= new Client();

            $myBody['name'] = "Demo";
            $request = $client->post($this->url,  ['body'=>$myBody]);
            $response = $request->send();

            dd($response);
        }

        public function putRaybaba()
        {
            $client= new \GuzzleHttp\Client();

            $yourBody['name']= "Demo here";


        }

}
