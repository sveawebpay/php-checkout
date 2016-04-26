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

    private $header;

    private $body;

    private $httpCode;


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
                //$this->content = $content;
                break;
            default:
                throw new SveaApiException($this->header['ErrorMessage'], $this->httpCode);
                break;
        }
    }

    /**
     * Return response content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->body;
    }

    public function setHeader($response)
    {
        $headers = array();

        // Split the string on every "double" new line.
        $arrRequests = explode("\r\n\r\n", $response);

        foreach (explode("\r\n", $arrRequests[0]) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        $this->header = $headers;
    }

    public function setBody($response)
    {
        $arrRequests = explode("\r\n\r\n", $response);

        $this->body = $arrRequests[1];
    }
}
