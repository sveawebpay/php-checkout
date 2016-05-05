<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;

class OrderFactory
{

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnCreateOrderClass(Connector $connector)
    {
        return new CreateOrder($connector);
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnGetOrderClass(Connector $connector)
    {
        return new GetOrder($connector);
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnUpdateOrderClass(Connector $connector)
    {
        return new UpdateOrder($connector);
    }
}
