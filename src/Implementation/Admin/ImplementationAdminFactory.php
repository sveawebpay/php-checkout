<?php

namespace Implementation\Admin;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\Admin\ValidateDeliverOrderData;

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
}