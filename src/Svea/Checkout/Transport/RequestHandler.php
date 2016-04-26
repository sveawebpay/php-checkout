<?php

namespace Svea\Checkout\Transport;

/**
 * Class RequestHandler
 * Request model
 *
 * @package Svea\Checkout\Transport
 */
class RequestHandler
{
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
        $this->method = 'POST';
    }

    /**
     * Set GET method to the request.
     */
    public function setGetMethod()
    {
        $this->method = 'GET';
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
}
