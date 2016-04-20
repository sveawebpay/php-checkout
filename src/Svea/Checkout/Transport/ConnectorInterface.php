<?php

namespace Svea\Checkout\Transport;

/**
 * Interface IConnector
 * @package Svea\Checkout\Transport
 */
interface ConnectorInterface
{
    /**
     *  Test API URL
     */
    const TEST_BASE_URL = 'api.test.svea.com/';

    /**
     *  Base API URL
     */
    const BASE_URL = 'api.svea.com/';


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
     * @param Request $request
     *
     * @return Response
     */
    public function send(Request $request);

}