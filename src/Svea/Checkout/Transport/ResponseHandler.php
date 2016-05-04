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
     * API response successful http codes
     * @var array
     */
    private $httpSuccessfulCodes = array(200, 201, 302);

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

        $this->setHeader();
        $this->setBody();
    }

    /**
     * Handle Svea Checkout API response
     *
     * @throws SveaApiException
     */
    public function handleClientResponse()
    {
        if (!in_array($this->httpCode, $this->httpSuccessfulCodes)) {
            $this->throwError();
        }
    }

    /**
     * @throws SveaApiException
     */
    public function throwError()
    {
        $errorMessage = isset($this->header['http_code']) ? $this->header['http_code'] : 'Undefined error occurred.';
        if (isset($this->header['ErrorMessage'])) {
            $errorMessage = $this->header['ErrorMessage'];
        }

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
     */
    public function setHeader()
    {
        $headers = array();

        /**
         * Split the string on every "double" new line.
         * First is header data, second is body content
         */
        $arrRequests = explode(PHP_EOL . PHP_EOL, $this->content);
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

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    public function setBody()
    {
        $arrRequests = explode(PHP_EOL . PHP_EOL, $this->content);

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
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }
}
