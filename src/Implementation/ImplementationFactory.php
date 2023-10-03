<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\ValidateCreateOrderData;
use Svea\Checkout\Validation\ValidateCreateTokenOrderData;
use Svea\Checkout\Validation\ValidateGetOrderData;
use Svea\Checkout\Validation\ValidateUpdateOrderData;
use Svea\Checkout\Validation\ValidateGetAvailablePartPaymentCampaignsData;
use Svea\Checkout\Validation\ValidateGetTokenData;
use Svea\Checkout\Validation\ValidateGetTokenOrderData;

class ImplementationFactory
{
    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnCreateOrderClass(Connector $connector)
    {
        return new CreateOrder($connector, new ValidateCreateOrderData());
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnCreateTokenOrderClass(Connector $connector) {
        return new CreateTokenOrder($connector, new ValidateCreateTokenOrderData());
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnGetOrderClass(Connector $connector)
    {
        return new GetOrder($connector, new ValidateGetOrderData());
    }
   
    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnGetTokenOrderClass(Connector $connector)
    {
        return new GetTokenOrder($connector, new ValidateGetTokenOrderData());
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnGetTokenClass(Connector $connector)
    {
        return new GetToken($connector, new ValidateGetTokenData());
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnUpdateOrderClass(Connector $connector)
    {
        return new UpdateOrder($connector, new ValidateUpdateOrderData());
    }

    /**
     * @param Connector $connector
     * @return ImplementationInterface
     */
    public static function returnGetAvailablePartPaymentCampaignsClass(Connector $connector)
    {
        return new GetAvailablePartPaymentCampaigns($connector, new ValidateGetAvailablePartPaymentCampaignsData());
    }
}
