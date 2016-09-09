<?php

namespace Svea\Checkout\Transport;

use \Exception;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaConnectorException;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Transport\Http\CurlRequest;

/**
 * Class Connector - Used for authentication and connect with Svea Checkout API over HTTP.
 *
 * @package Svea\Checkout\Transport
 */
class Connector
{
    /**
     * Base URL For Svea Checkout Test server
     */
    const TEST_BASE_URL = 'http://webpaycheckoutservice.test.svea.com';

    /**
     * Base URL For Svea Checkout Dev server
     */
    const DEV_BASE_URL = 'http://webpaycheckoutservice.dev.svea.com';

    /**
     * Base URL For Svea Checkout UAT server
     */
    const UAT_BASE_URL = 'http://webpaycheckoutservice.uat.svea.com';

    /**
     * Base URL For Svea Checkout Demo server
     */
    const DEMO_BASE_URL = 'http://webpaycheckoutservice.demo.svea.com';

    /**
     * Base URL For Svea Checkout Demo server
     */
    const STAGE_BASE_URL = 'http://checkoutapistage.svea.com';

    /**
     * Base URL For Svea Checkout Production server
     */
    const PROD_BASE_URL = 'http://checkoutapi.svea.com';

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
     * @var string $baseApiUrl
     */
    private $baseApiUrl;

    /**
     * Svea Checkout Api client.
     *
     * @var ApiClient $apiClient
     */
    private $apiClient;


    /**
     * Connector constructor.
     *
     * @param ApiClient $apiClient      HTTP transport client
     * @param string    $merchantId     Merchant Id
     * @param string    $sharedSecret   Shared secret
     * @param string    $baseApiUrl     Base URL for HTTP request to Svea Checkout API
     */
    public function __construct($apiClient, $merchantId, $sharedSecret, $baseApiUrl)
    {
        $this->merchantId = $merchantId;
        $this->sharedSecret = $sharedSecret;
        $this->baseApiUrl = $baseApiUrl;
        $this->apiClient = $apiClient;

        $this->validateData();
    }

    /**
     * Initializes connector instance
     *
     * @param string $merchantId    Merchant Id
     * @param string $sharedSecret  Shared secret
     * @param string $apiUrl        Base URL for HTTP request to Svea Checkout API
     * @return Connector
     */
    public static function init($merchantId, $sharedSecret, $apiUrl = self::PROD_BASE_URL)
    {
        $httpClient = new ApiClient(new CurlRequest());

        return new static($httpClient, $merchantId, $sharedSecret, $apiUrl);
    }

    /**
     * Validate Client credentials data.
     */
    private function validateData()
    {
        $this->validateMerchantId();
        $this->validateSharedSecret();
        $this->validateBaseApiUrl();
    }

    /**
     * Validate client merchant ID
     *
     * @throws SveaConnectorException    If merchant ID is empty
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
     * Validate shared secret
     *
     * @throws SveaConnectorException   If shared secret is empty
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
     * Validate API base url.
     *
     * @throws SveaConnectorException   If base API URL is empty or if not valid
     */
    private function validateBaseApiUrl()
    {
        if (empty($this->baseApiUrl)) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::MISSING_API_BASE_URL),
                ExceptionCodeList::MISSING_API_BASE_URL
            );
        } elseif ($this->baseApiUrl !== self::TEST_BASE_URL && $this->baseApiUrl !== self::PROD_BASE_URL) {
            throw new SveaConnectorException(
                ExceptionCodeList::getErrorMessage(ExceptionCodeList::INCORRECT_API_BASE_URL),
                ExceptionCodeList::INCORRECT_API_BASE_URL
            );
        }
    }

    /**
     * Create request to the API client.
     *
     * @param Request   $request    Request model contains all data for request to the Svea Checkout API
     * @throws SveaApiException     If some error is encountered or If API responds with some error
     * @return ResponseHandler
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
     * Create Authorization Token from Request model.
     * Every request to the API must be authenticated by using the Authorization HTTP request-header.
     * Only a proprietary Svea authentication scheme is supported.
     * base64 ({merchantId}:sha512 (requestBody + sharedSecret))
     *
     * @param Request $request  Request model with all necessary data for HTTP request
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
    public function getBaseApiUrl()
    {
        return $this->baseApiUrl;
    }

    /**
     * @return ApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }
}
