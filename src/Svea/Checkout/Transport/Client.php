<?php

namespace Svea\Checkout\Transport;

use \Exception;

class Client
{
    /*
     * Call Api
     *
     * @return ResponseInterface
     * */
    public function call(Request $request)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $request->getApiUrl());

        if ($request->getMethod() == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());
        }

        $header = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Svea ' . $request->getAuthorizationToken();

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);


        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //$curlResponse = new FormatHttpResponse();

        //curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$curlResponse, 'processHeader'));

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($response === false || $info === false) {
            throw new Exception(
                "Connection to '{$request->getApiUrl()}' failed: {$error}"
            );
        }

        // @todo ser resource / treba da se vidi sta ce ovde da bude
        //$result = $curlResponse->handleResponse($resource, intval($info['http_code']), strval($response));

        $result = '';

        return $result;
    }
}

