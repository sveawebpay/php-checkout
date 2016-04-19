<?php

namespace Svea\Checkout\Transport;


use Svea\Checkout\Request\RequestInterface;

class Connector implements ConnectorInterface
{
    private $merchantId;
    private $sharedSecret;
    private $apiUrl;
    private $client;

    /**
     * Connector constructor.
     * @param ClientInterface
     * @param $merchantId
     * @param $sharedSecret
     * @param $apiUrl
     */
    public function __construct($client, $merchantId, $sharedSecret, $apiUrl)
    {
        $this->client = $client;
        $this->merchantId = $merchantId;
        $this->sharedSecret = $sharedSecret;
        $this->apiUrl = $apiUrl;
    }


    public static function create($merchantId, $sharedSecret, $apiUrl)
    {
        // @todo Client is class for calling API
        $client = null;

        return new static($client, $merchantId, $sharedSecret, $apiUrl);
    }


    public function send(RequestInterface $request)
    {
        // TODO: Implement send() method.
    }
}