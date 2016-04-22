<?php

namespace Svea\Checkout\Transport;

use \Exception;
use Svea\Checkout\Transport\Http\HttpRequestInterface;

/**
 * Class Client
 * @package Svea\Checkout\Transport
 */
class ApiClient
{
    /**
     * @var HttpRequestInterface $httpClient
     */
    private $httpClient;

    /**
     * Client constructor.
     * @param $httpClient
     */
    public function __construct(HttpRequestInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param Request $request
     * @return ResponseHandler
     * @throws Exception
     */
    public function sendRequest(Request $request)
    {
        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Svea ' . $request->getAuthorizationToken();

        $this->httpClient->setOption(CURLOPT_URL, $request->getApiUrl());
        $this->httpClient->setOption(CURLOPT_HTTPHEADER, $header);
        $this->httpClient->setOption(CURLOPT_RETURNTRANSFER, 1);
        if ($request->getMethod() == 'POST') {
            $this->httpClient->setOption(CURLOPT_POST, 1);
            $this->httpClient->setOption(CURLOPT_POSTFIELDS, $request->getBody());
        }

        $curlResponse = $this->httpClient->execute();
        $httpCode = $this->httpClient->getInfo(CURLINFO_HTTP_CODE);
        $curlError = $this->httpClient->getError();
        $this->httpClient->close();

        if (!empty($curlError)) {
            throw new Exception("Connection to '{$request->getApiUrl()}' failed: {$curlError}");
        }

        $clientResponse = new ResponseHandler();
        $clientResponse->handleClientResponse($curlResponse, $httpCode, $curlError);

        return $clientResponse;
    }

    /**
     * @return HttpRequestInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpRequestInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }
}

