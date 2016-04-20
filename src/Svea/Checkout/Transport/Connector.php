<?php

namespace Svea\Checkout\Transport;

use \Exception;

class Connector
{
    /**
     *  Test API URL
     */
    const TEST_BASE_URL = 'api.test.svea.com/';

    /**
     *  Base API URL
     */
    const BASE_URL = 'api.svea.com/';

    private $merchantId;
    private $sharedSecret;
    private $apiUrl;

    /**
     * @var Client $client
     */
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
        $this->createAuthorizationToken($request);

        try {
            return $this->client->call($request);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function createAuthorizationToken(Request $request)
    {
        $authToken = base64_encode($this->merchantId . ':' . hash('sha512', $request->getBody() . $this->sharedSecret));
        $request->setAuthorizationToken($authToken);
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
}