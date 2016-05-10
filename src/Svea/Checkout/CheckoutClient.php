<?php

namespace Svea\Checkout;

use Svea\Checkout\Implementation\ImplementationFactory;
use Svea\Checkout\Transport\Connector;

/**
 * Class CheckoutClient
 *
 * @package Svea\Checkout
 * @author Svea
 */
class CheckoutClient
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
    public function create(array $data)
    {
        $createOrder = ImplementationFactory::returnCreateOrderClass($this->connector);
        $createOrder->execute($data);

        return $createOrder->getResponse();
    }

    /**
     * Update existing Svea Checkout order.
     *
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        $updateOrder = ImplementationFactory::returnUpdateOrderClass($this->connector);
        $updateOrder->execute($data);

        return $updateOrder->getResponse();
    }

    /**
     * Return Svea Checkout order data.
     *
     * @param mixed $data
     * @return mixed
     */
    public function get($data)
    {
        $getOrder = ImplementationFactory::returnGetOrderClass($this->connector);
        $getOrder->execute($data);

        return $getOrder->getResponse();
    }
}
