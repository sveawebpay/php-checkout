<?php

namespace Svea\Checkout\Transport;

use \Exception;

/**
 * Class Client
 * @package Svea\Checkout\Transport
 */
class Client
{
    /**
     * @param Request $request
     * @return ResponseHandler
     * @throws Exception
     */
    public function request(Request $request)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $request->getApiUrl());

        if ($request->getMethod() == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());
        }

        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Svea ' . $request->getAuthorizationToken();

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);


        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //$curlResponse = new FormatHttpResponse();

        //curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$curlResponse, 'processHeader'));

        $curlResponse = curl_exec($curl);

        $curlInfo = curl_getinfo($curl);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlResponse === false || $curlInfo === false) {
            throw new Exception("Connection to '{$request->getApiUrl()}' failed: {$curlError}");
        }

        $clientResponse = new ResponseHandler();
        $clientResponse->handleClientResponse($curlResponse, $curlInfo, $curlError);

        return $clientResponse;
    }
}

