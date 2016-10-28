<?php

namespace Svea\Checkout;

use Implementation\Admin\ImplementationAdminFactory;
use Svea\Checkout\Transport\Connector;

class CheckoutAdminClient
{
    /**
     * Transport connector used to make HTTP request to Svea Checkout API.
     *
     * @var Connector
     */
    private $connector;

    /**
     * CheckoutClient constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Create new Svea Checkout order.
     *
     * @param array $data
     * @return mixed
     */
    public function deliverOrder(array $data)
    {
        $createOrder = ImplementationAdminFactory::returnDeliverOrderClass($this->connector);
        $createOrder->execute($data);

        return $createOrder->getResponse();
    }
}