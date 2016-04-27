<?php

namespace Svea\Checkout\Transport\Http;

/**
 * Class CurlRequest
 *
 * @package Svea\Checkout\Transport
 */
class CurlRequest implements HttpRequestInterface
{
    /**
     * @var null|resource
     */
    private $handle = null;


    /**
     * CurlRequest constructor.
     */
    public function __construct()
    {
        $this->handle = curl_init();
    }

    /**
     * @param $name
     * @param $value
     */
    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->handle);
    }
    
    /**
     * @param $name
     * @return mixed
     */
    public function getInfo($name)
    {
        return curl_getinfo($this->handle, $name);
    }

    /**
     * @return mixed
     */
    public function getFullInfo()
    {
        return curl_getinfo($this->handle);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return curl_error($this->handle);
    }

    /**
     * Return error number (If error exist error number will be grater than 0)
     * @return int
     */
    public function getErrorNumber()
    {
        return curl_errno($this->handle);
    }

    /**
     *
     */
    public function close()
    {
        curl_close($this->handle);
    }
}
