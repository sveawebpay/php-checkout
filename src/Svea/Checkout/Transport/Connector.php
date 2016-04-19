<?php

namespace Svea\Checkout\Transport;


use Svea\Checkout\Request\RequestInterface;

class Connector implements ConnectorInterface
{

    /**
     * Create a request object
     *
     * @param $url
     * @param string $method
     * @param array $option
     *
     * @return RequestInterface
     */
    public static function create( )
    {
        // TODO: Implement createRequest() method.
    }

    /**
     * Sends the request
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        // TODO: Implement send() method.
    }
}