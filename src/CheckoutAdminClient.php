<?php

namespace Svea\Checkout;

use Svea\Checkout\Implementation\ImplementationInterface;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Implementation\Admin\ImplementationAdminFactory;
use Svea\Checkout\Transport\ResponseHandler;

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
        return $this->executeAction(ImplementationAdminFactory::returnGetOrderClass($this->connector), $data);
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
        return $this->executeAction(ImplementationAdminFactory::returnGetOrderDeliveryClass($this->connector), $data);
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
        return $this->executeAction(ImplementationAdminFactory::returnGetOrderAddressesClass($this->connector), $data);
    }

    /**
     * Deliver Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function deliverOrder($data)
    {
        return $this->executeAction(ImplementationAdminFactory::returnDeliverOrderClass($this->connector), $data);
    }

    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function cancelOrderAmount($data)
    {
        return $this->executeAction(ImplementationAdminFactory::returnCancelOrderAmountClass($this->connector), $data);
    }

    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function cancelOrderRow($data)
    {
        return $this->executeAction(ImplementationAdminFactory::returnCancelOrderRowClass($this->connector), $data);
    }

    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function creditOrderRows($data)
    {
        return $this->executeAction(ImplementationAdminFactory::returnCreditOrderRowsClass($this->connector), $data);
    }
    /**
     * Cancel amount for Svea Checkout order.
     *
     * @param int $data
     * @return mixed
     */
    public function creditOrderAmount($data)
    {
        return $this->executeAction(ImplementationAdminFactory::returnCreditOrderAmountClass($this->connector), $data);
    }

    /**
     * @param ImplementationInterface $actionObject
     * @param mixed $inputData
     * @return array
     */
    private function executeAction($actionObject, $inputData)
    {
        $actionObject->execute($inputData);

        /**
         * @var ResponseHandler $responseHandler
         */
        $responseHandler = $actionObject->getResponse();

        return $responseHandler->getWholeResponse();
    }
}
