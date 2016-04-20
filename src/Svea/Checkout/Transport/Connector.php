<?php

namespace Svea\Checkout\Transport;

use \Exception;

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

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return mixed
     */
    public function getSharedSecret()
    {
        return $this->sharedSecret;
    }

    /**
     * @param mixed $sharedSecret
     */
    public function setSharedSecret($sharedSecret)
    {
        $this->sharedSecret = $sharedSecret;
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param mixed $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }


    public static function create($merchantId, $sharedSecret, $apiUrl)
    {
        // @todo Client is class for calling API
        $client = new Client();

        return new static($client, $merchantId, $sharedSecret, $apiUrl);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function send(Request $request)
    {
        try {
            return $this->client->call($request);
        } catch (Exception $e) {
            var_dump($request);
            echo $e->getMessage();
        }
    }

    /**
     * Create a request object
     *
     * @param $url
     * @param string $method
     * @param array $option
     *
     * @return Request
     */
    public static function createRequest($url, $method = 'GET', array $option = [])
    {
        // TODO: Implement createRequest() method.
    }
}