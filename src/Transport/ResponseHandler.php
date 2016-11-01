<?php

namespace Svea\Checkout\Transport;

use Svea\Checkout\Exception\SveaApiException;

/**
 * Class ResponseHandler - HTTP response handler
 *
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
        $this->content  = $content;
        $this->httpCode = $httpCode;

        $this->setHeader();
        $this->setBody();
    }

    /**
     * Handle Svea Checkout API response.
     * Prepare error message if response is not successful.
     *
     * @throws SveaApiException
     */
    public function handleClientResponse()
    {
        if (!in_array($this->httpCode, $this->httpSuccessfulCodes)) {
            $errorMessage = 'Undefined error occurred.';

            if (isset($this->header['http_code'])) {
                $errorMessage = $this->header['http_code'];
            }
            if (isset($this->header['ErrorMessage'])) {
                $errorMessage = $this->header['ErrorMessage'];
            }

            throw new SveaApiException($errorMessage, $this->httpCode);
        }
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Prepare body data from response.
     */
    public function setBody()
    {
        /**
         * Split the string on "double" new line.
         * First is header data, second is body content
         * We need to use Windows "end of line" char because of response format
         */
        $arrRequests = explode("\r\n\r\n", $this->content, 2); // Split on first occurrence

        if (is_array($arrRequests) && count($arrRequests) > 1) {
            $this->body = $arrRequests[1];
        }
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
    public function getFullContent()
    {
        $returnData = array();

        $header = $this->getHeader();

        if (isset($header['Location'])) {
            $returnData['Header'] = $this->getHeader();
        }

        $returnData['Response'] = $this->getContent();

        return $returnData;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Create array of header information from response.
     */
    public function setHeader()
    {
        $headers = array();

        /**
         * Split the string on "double" new line.
         * First is header data, second is body content
         * We need to use Windows "end of line" char because of response format
         */
        $arrRequests          = explode("\r\n\r\n", $this->content); // Split on first occurrence
        $headerLines          = explode("\r\n", $arrRequests[0]); // Split on first occurrence
        $headers['http_code'] = $headerLines[0];

        foreach ($headerLines as $i => $line) {
            if ($i > 0) {
                list ($key, $value) = explode(':', $line, 2); // Split on first occurrence
                $headers[trim($key)] = trim($value);
            }
        }

        $this->header = $headers;
    }

    /**
     * Return response content
     *
     * @return mixed
     * @throws SveaApiException
     */
    public function getContent()
    {
        $result = json_decode($this->body, true);

        if ($result === null) {
            throw new SveaApiException('Response format is not valid, JSON decode error', 1000);
        }

        return $result;
    }
}
