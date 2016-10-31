<?php

namespace Svea\Checkout\Model;

/**
 * Class Request
 * Request model - Containing all data necessary for request to the API.
 *
 * @package Svea\Checkout\Model
 */
class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    
    /**
     * Authorization token, sent trough authorization header in request.
     *
     * @var string $authorizationToken
     */
    private $authorizationToken;

    /**
     * Request body - json encoded.
     *
     * @var string $body
     */
    private $body;

    /**
     * Request method.
     *
     * @var string $method
     */
    private $method;

    /**
     * Svea Checkout API Url.
     *
     * @var string $apiUrl
     */
    private $apiUrl;

    /**
     * @var $merchantId
     */
    private $merchantId;

    /**
     * @var $secret
     */
    private $secret;

    private $timestamp;

    /**
     * Return authorization token.
     *
     * @return string
     */
    public function getAuthorizationToken()
    {
        return $this->authorizationToken;
    }

    /**
     * Set authorization token.
     *
     * @param string $authorizationToken
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = $authorizationToken;
    }

    /**
     * Return request body data as json encoded array.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set request body data as json encoded array
     *
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set POST method to the request.
     */
    public function setPostMethod()
    {
        $this->method = self::METHOD_POST;
    }

    /**
     * Set GET method to the request.
     */
    public function setGetMethod()
    {
        $this->method = self::METHOD_GET;
    }

    /**
     * Set PUT method to the request.
     */
    public function setPutMethod()
    {
        $this->method = self::METHOD_PUT;
    }

    /**
     * Set PATCH method to the request.
     */
    public function setPatchMethod()
    {
        $this->method = self::METHOD_PATCH;
    }

    /**
     * Return full request API url.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Set API url.
     *
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
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
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
}
