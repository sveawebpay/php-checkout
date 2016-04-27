<?php

namespace Svea\Checkout\Transport;

use Svea\Checkout\Exception\SveaApiException;

/**
 * Class ResponseHandler - HTTP response handler
 * @package Svea\Checkout\Transport
 */
class ResponseHandler
{
    /**
     * Svea Checkout Api response content.
     *
     * @var mixed $content
     */
    private $content;

    /**
     * @var array $header
     */
    private $header;

    /**
     * Json string
     *
     * @var string $body
     */
    private $body;

    /**
     * @var int $httpCode
     */
    private $httpCode;


    /**
     * ResponseHandler constructor.
     *
     * @param $content
     * @param $httpCode
     */
    public function __construct($content, $httpCode)
    {
        $this->content = $content;
        $this->httpCode = $httpCode;

        $this->setHeader($content);
        $this->setBody($content);
    }

    /**
     * Handle Svea Checkout API response
     *
     * @throws SveaApiException
     */
    public function handleClientResponse()
    {
        switch ($this->httpCode) {
            case 200:
            case 201:
            case 302:
                break;
            default:
                $this->throwError();
                break;
        }
    }

    /**
     * @throws SveaApiException
     */
    public function throwError()
    {
        $errorMessage = isset($this->header['http_code']) ? $this->header['http_code'] : 'Undefined error occurred.';
        if (isset($this->header['ErrorMessage']))
            $errorMessage = $this->header['ErrorMessage'];

        throw new SveaApiException($errorMessage, $this->httpCode);
    }

    /**
     * Return response content
     *
     * @return mixed
     */
    public function getContent()
    {
        return json_decode($this->body, true);
    }

    /**
     * Create array of header information
     *
     * @param $response
     */
    public function setHeader($response)
    {
        $headers = array();

        /**
         * Split the string on every "double" new line.
         * First is header data, second is body content
         */
        $arrRequests = explode(PHP_EOL . PHP_EOL, $response);
        $headerLines = explode(PHP_EOL, $arrRequests[0]);
        $headers['http_code'] = $headerLines[0];

        foreach ($headerLines as $i => $line) {
            if ($i > 0) {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        $this->header = $headers;
    }

    public function setBody($response)
    {
        $arrRequests = explode(PHP_EOL . PHP_EOL, $response);

        $this->body = $arrRequests[1];
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param mixed $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }
}
