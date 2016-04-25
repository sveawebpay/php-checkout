<?php

namespace Svea\Checkout\Transport;

use \Exception;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaConnectorException;
use Svea\Checkout\Transport\Http\CurlRequest;

/**
 * Class Connector
 * @package Svea\Checkout\Transport
 */
class Connector
{
    /**
     * Base URL For Svea Checkout test server
     */
    const TEST_BASE_URL = 'http://sveawebpaycheckoutws.test.svea.com/';

    /**
     * Base URL For Svea Checkout production server
     */
    const BASE_URL = 'api.svea.com/';

    /**
     * @var string $merchantId
     */
    private $merchantId;

    /**
     * @var string $sharedSecret
     */
    private $sharedSecret;

    /**
     * @var string $apiUrl
     */
    private $apiUrl;

    /**
     * @var ApiClient $client
     */
    private $client;


    /**
     * Connector constructor.
     * @param $client
     * @param $merchantId
     * @param $sharedSecret
     * @param $apiUrl
     */
    private function __construct($client, $merchantId, $sharedSecret, $apiUrl)
    {
        $this->client = $client;
        $this->merchantId = $merchantId;
        $this->sharedSecret = $sharedSecret;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param $merchantId
     * @param $sharedSecret
     * @param $apiUrl
     * @return static
     * @throws SveaConnectorException
     */
    public static function create($merchantId, $sharedSecret, $apiUrl)
    {
        $client = new ApiClient(new CurlRequest());

        if (empty($merchantId)) {
            throw new SveaConnectorException(ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_MERCHANT_ID), ExceptionCodeList::MISSING_MERCHANT_ID);
        }
        if (empty($sharedSecret)) {
            throw new SveaConnectorException(ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_SHARED_SECRET), ExceptionCodeList::MISSING_SHARED_SECRET);
        }
        if (empty($apiUrl)) {
            throw new SveaConnectorException(ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_API_BASE_URL), ExceptionCodeList::MISSING_API_BASE_URL);
        }

        return new static($client, $merchantId, $sharedSecret, $apiUrl);
    }

    /**
     * @param RequestHandler $request
     * @return ResponseHandler
     * @throws SveaApiException
     */
    public function send(RequestHandler $request)
    {
        $this->createAuthorizationToken($request);

        try {
            $response = $this->client->sendRequest($request);
            return $response;
        } catch (SveaApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new SveaApiException('API communication error', 1010);
        }
    }

    /**
     * @param RequestHandler $request
     */
    private function createAuthorizationToken(RequestHandler $request)
    {
        $authToken = base64_encode($this->merchantId . ':' . hash('sha512', $request->getBody() . $this->sharedSecret));
        $request->setAuthorizationToken($authToken);
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getSharedSecret()
    {
        return $this->sharedSecret;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return ApiClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}