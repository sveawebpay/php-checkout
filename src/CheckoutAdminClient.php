<?php

namespace Svea\Checkout;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Implementation\Admin\ImplementationAdminFactory;

/**
 * Class CheckoutAdminClient
 *
 * @package Svea\Checkout
 * @author  Svea
 */
class CheckoutAdminClient
{
    /**
     * Transport connector used to make HTTP request to Svea Checkout API.
     *
     * @var Connector
     */
    private $connector;

    /**
     * CheckoutAdminClient constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Get Svea Checkout order information.
     *
     * @param int $data
     *
     * @return mixed
     */
    public function getOrder($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnGetOrderClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

    /**
     * Get Svea Checkout order delivery information.
     *
     * @param int $data
     *
     * @return mixed
     */
    public function getOrderDelivery($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnGetOrderDeliveryClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

    /**
     * Get Svea Checkout order delivery information.
     *
     * @param int $data
     *
     * @return mixed
     */
    public function getOrderAddresses($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnGetOrderAddressesClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

    /**
     * Deliver Svea Checkout order.
     *
     * @param int $data
     *
     * @return mixed
     */
    public function deliverOrder($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnDeliverOrderClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function cancelOrderAmount($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnCancelOrderAmountClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function cancelOrderRow($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnCancelOrderRowClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }
    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function creditOrderAmount($data)
    {
        $deliverOrder = ImplementationAdminFactory::returnCreditOrderAmountClass($this->connector);
        $deliverOrder->execute($data);

        return $deliverOrder->getResponse();
    }

}