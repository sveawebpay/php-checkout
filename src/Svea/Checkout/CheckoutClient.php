<?php

namespace Svea\Checkout;


use Svea\Checkout\Implementation\CreateOrder;
use Svea\Checkout\Transport\Connector;

class CheckoutClient
{
    private $connector;

    /**
     * CheckoutClient constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function create(array $data)
    {
        $co = new CreateOrder($this->connector);
        return $co->execute($data);
    }

    public function update(array $data)
    {

    }

    public function get($data)
    {

    }
}


class Response
{
    public static function validate($response)
    {

    }

}