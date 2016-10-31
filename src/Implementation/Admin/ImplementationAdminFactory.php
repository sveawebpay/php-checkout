<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\Admin\ValidateGetOrderData;
use Svea\Checkout\Validation\Admin\ValidateDeliverOrderData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderDeliveryData;

class ImplementationAdminFactory
{
    /**
     * @param Connector $connector
     * @return DeliverOrder
     */
    public static function returnDeliverOrderClass(Connector $connector)
    {
        return new DeliverOrder($connector, new ValidateDeliverOrderData());
    }

    /**
     * @param Connector $connector
     * @return GetOrder
     */
    public static function returnGetOrderClass(Connector $connector)
    {
        return new GetOrder($connector, new ValidateGetOrderData());
    }
    /**
     * @param Connector $connector
     * @return GetOrderDelivery
     */
    public static function returnGetOrderDeliveryClass(Connector $connector)
    {
        return new GetOrderDelivery($connector, new ValidateGetOrderDeliveryData());
    }

    /**
     * @param Connector $connector
     * @return CancelOrderAmount
     */
    public static function returnCancelOrderAmountClass(Connector $connector)
    {
        return new CancelOrderAmount($connector, new ValidateDeliverOrderData());
    }
}