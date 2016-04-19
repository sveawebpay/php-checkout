<?php

namespace Svea\Checkout\Transport;
use Svea\Checkout\Request\RequestInterface;


/**
 * Interface IConnector
 * @package Svea\Checkout\Transport
 */
interface ConnectorInterface
{
    /**
     *  Test API URL for Sweden
     */
    const SVE_TEST_URL = 'api.svea.com';

    /**
     *  Base API URL for Sweden
     */
    const SVE_BASE_URL = 'api.test.svea.com';


    /**
     * Create a request object
     *
     * @param $url
     * @param string $method
     * @param array $option
     *
     * @return RequestInterface
     */
    public static function createRequest($url, $method = 'GET', array $option = []);


    /**
     * Sends the request
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request);

}