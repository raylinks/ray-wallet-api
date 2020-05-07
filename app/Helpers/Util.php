<?php
namespace App\Helpers;

class Util
{

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

    private static function getPrefix($class_name)
    {
        return config('app.reference_prefixes')[$class_name];
    }

    /**
     * Gets the ID of a resource based on the uuid
     *
     * @param Type $uuid The uuid of the card
     * @return Type resource id
     **/
    public static function getIdFromUuid($uuid, $table)
    {
        try{
            $resource =  DB::table($table)->where('uuid', $uuid)->first();
        }catch(Exception $e){
            Throw new Exception('No ID found for this UUID');
        }
        return $resource->id;
    }

    public static function formatErrors($messages)
    {
        $errors = [];
        foreach ($messages as $key => $value) {
            array_push($errors, $value);
        }
        return $errors;
    }

    public static function sendData($url, $form_data, $headers){/*
        $client = new Client();
        $request = $client->get(env('PAYSTACK_VERIFY') . $reference, [
            'headers' => [
                "Authorization" => "Bearer " . env('SECRET_TEST_KEY'),
                "cache-control" => "no-cache",
                "content-type: application/json",
            ],
        ], array());
        //   $request->setBody($postdata); #set body!
        $response = json_decode($request->getBody()->getContents());
        return $response;
        */
    }

    /**
     * @author Kennedy Osaze [https://github.com/kennedy-osaze]
     *
     * Checks to see if the current request is secure (uses ssl certificate)
     * Even when it is behind cloudflare
     *
     * @return bool
     */
    public static function isRequestSecure() {
        $request = request();

        if ($forwarded_protocol = $request->server->get('HTTP_X_FORWARDED_PROTO')) {
            return (strtolower((string) $forwarded_protocol) === 'https');
        }

        if ($cloudflare_visitor = $request->server->get('HTTP_CF_VISITOR')) {
            $cf_visitor_data = json_decode($cloudflare_visitor);
            return isset($cf_visitor_data->scheme) && strtolower((string) $cf_visitor_data->scheme) === 'https';
        }

        return $request->isSecure();
    }
}
