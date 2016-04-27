<?php

namespace Svea\Checkout\Transport;

use \Exception;
use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Transport\Http\HttpRequestInterface;

/**
 * Class Client
 *
 * @package Svea\Checkout\Transport
 */
class ApiClient
{
    /**
     * Implementation of Http client interface.
     *
     * @var HttpRequestInterface $httpClient
     */
    private $httpClient;

    /**
     * Client constructor.
     *
     * @param $httpClient
     */
    public function __construct(HttpRequestInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Send request to Svea Checkout API.
     *
     * @param RequestHandler $request
     * @return ResponseHandler
     * @throws Exception
     */
    public function sendRequest(RequestHandler $request)
    {
        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Svea ' . $request->getAuthorizationToken();

        $this->httpClient->setOption(CURLOPT_URL, $request->getApiUrl());
        $this->httpClient->setOption(CURLOPT_HTTPHEADER, $header);
        $this->httpClient->setOption(CURLOPT_RETURNTRANSFER, 1);
        $this->httpClient->setOption(CURLOPT_HEADER, 1);

        if ($request->getMethod() == 'POST') {
            $this->httpClient->setOption(CURLOPT_POST, 1);
            $this->httpClient->setOption(CURLOPT_POSTFIELDS, $request->getBody());

            echo "<pre>" . print_r(json_decode($request->getBody(), true), true) . "</pre>"; // @todo remove this line
        }

        $httpResponse = $this->httpClient->execute();
        $httpCode = $this->httpClient->getInfo(CURLINFO_HTTP_CODE);

        $httpError = $this->httpClient->getError();
        $errorNumber = $this->httpClient->getErrorNumber();

        $this->httpClient->close();

        if ($errorNumber > 0) {
            throw new Exception($httpError, ExceptionCodeList::CLIENT_API_ERROR);
        }

        $clientResponse = new ResponseHandler($httpResponse, $httpCode);
        $clientResponse->handleClientResponse();

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
