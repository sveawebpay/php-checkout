<?php


namespace Svea\Checkout\Transport\Http;


/**
 * Class CurlRequest
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

    public function getErrorNumber()
    {
        /*
         * 0    - no error
         * > 0  - some error occurred
         * */
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