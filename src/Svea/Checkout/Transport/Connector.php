<?php

namespace Svea\Checkout\Transport;

use \Exception;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaConnectorException;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Transport\Http\CurlRequest;

/**
 * Class Connector - Transport connector used to make HTTP request to Svea Checkout API.
 *
 * @package Svea\Checkout\Transport
 */
class Connector
{
    /**
     * Base URL For Svea Checkout test server
     */
    const TEST_BASE_URL = 'http://webpaycheckoutservice.test.svea.com';

    /**
     * Base URL For Svea Checkout production server
     */
    const PROD_BASE_URL = 'api.svea.com/';

    /**
     * Merchant identifier assigned to client by Svea.
     *
     * @var string $merchantId
     */
    private $merchantId;

    /**
     * Secret key assigned to Merchant Id by Svea.
     *
     * @var string $sharedSecret
     */
    private $sharedSecret;

    /**
     * Base Checkout API url.
     *
     * @var string $apiUrl
     */
    private $apiUrl;

    /**
     * Svea Checkout Api client.
     *
     * @var ApiClient $apiClient
     */
    private $apiClient;


    /**
     * Connector constructor.
     *
     * @param ApiClient $apiClient
     * @param string $merchantId
     * @param string $sharedSecret
     * @param string $apiUrl
     */
    public function __construct($apiClient, $merchantId, $sharedSecret, $apiUrl)
    {
        $this->merchantId = $merchantId;
        $this->sharedSecret = $sharedSecret;
        $this->apiUrl = $apiUrl;
        $this->apiClient = $apiClient;

        $this->validateData();
    }

    /**
     * Validate all input data.
     */
    private function validateData()
    {
        $this->validateMerchantId();
        $this->validateSharedSecret();
        $this->validateApiUrl();
    }

    /**
     * Validate shared secret
     *
     * @throws SveaConnectorException
     */
    private function validateSharedSecret()
    {
        if (empty($this->sharedSecret)) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_SHARED_SECRET),
                ExceptionCodeList::MISSING_SHARED_SECRET
            );
        }
    }

    /**
     * Validate client merchant ID
     *
     * @throws SveaConnectorException
     */
    private function validateMerchantId()
    {
        if (empty($this->merchantId)) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_MERCHANT_ID),
                ExceptionCodeList::MISSING_MERCHANT_ID
            );
        }
    }

    /**
     * Validate API base url.
     *
     * @throws SveaConnectorException
     */
    private function validateApiUrl()
    {
        if (empty($this->apiUrl)) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_API_BASE_URL),
                ExceptionCodeList::MISSING_API_BASE_URL
            );
        } elseif ($this->apiUrl !== self::TEST_BASE_URL && $this->apiUrl !== self::PROD_BASE_URL) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::INCORRECT_API_BASE_URL),
                ExceptionCodeList::INCORRECT_API_BASE_URL
            );
        }
    }

    /**
     * Create request to the API client.
     *
     * @param Request $request
     * @return ResponseHandler
     * @throws SveaApiException
     */
    public function sendRequest(Request $request)
    {
        $this->createAuthorizationToken($request);

        try {

            /**
             * @var ResponseHandler $response
             */
            $response = $this->apiClient->sendRequest($request);

            return $response->getContent();
        } catch (SveaApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new SveaApiException('API communication error', 1010, $e);
        }
    }

    /**
     * Initializes connector instance
     *
     * @param string $merchantId
     * @param string $sharedSecret
     * @param string $apiUrl
     * @return Connector
     */
    public static function init($merchantId, $sharedSecret, $apiUrl = self::PROD_BASE_URL)
    {
        $httpClient = new ApiClient(new CurlRequest());

        return new static($httpClient, $merchantId, $sharedSecret, $apiUrl);
    }

    /**
     * Create Authorization Token.
     *
     * @param Request $request
     */
    private function createAuthorizationToken(Request $request)
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
    public function getApiClient()
    {
        return $this->apiClient;
    }
}
