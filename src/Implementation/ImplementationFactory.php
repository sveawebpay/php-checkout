<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\ValidateCreateOrderData;
use Svea\Checkout\Validation\ValidateChangePaymentMethodData;
use Svea\Checkout\Validation\ValidateCreateTokenOrderData;
use Svea\Checkout\Validation\ValidateGetOrderData;
use Svea\Checkout\Validation\ValidateUpdateOrderData;
use Svea\Checkout\Validation\ValidateGetAvailablePartPaymentCampaignsData;
use Svea\Checkout\Validation\ValidateGetTokenData;
use Svea\Checkout\Validation\ValidateGetTokenOrderData;
use Svea\Checkout\Validation\ValidateUpdateTokenData;

class ImplementationFactory
{
    /**
     * @param Connector $connector
     * @return CreateOrder
     */
    public static function returnCreateOrderClass(Connector $connector)
    {
        return new CreateOrder($connector, new ValidateCreateOrderData());
    }

    /**
     * @param Connector $connector
     * @return CreateTokenOrder
     */
    public static function returnCreateTokenOrderClass(Connector $connector)
    {
        return new CreateTokenOrder($connector, new ValidateCreateTokenOrderData());
    }

    /**
     * @param Connector $connector
     * @return ChangePaymentMethod
     */
    public static function returnChangePaymentMethodClass(Connector $connector)
    {
        return new ChangePaymentMethod($connector, new ValidateChangePaymentMethodData());
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
     * @return GetTokenOrder
     */
    public static function returnGetTokenOrderClass(Connector $connector)
    {
        return new GetTokenOrder($connector, new ValidateGetTokenOrderData());
    }

    /**
     * @param Connector $connector
     * @return GetToken
     */
    public static function returnGetTokenClass(Connector $connector)
    {
        return new GetToken($connector, new ValidateGetTokenData());
    }

    /**
     * @param Connector $connector
     * @return UpdateToken
     */
    public static function returnUpdateTokenClass(Connector $connector)
    {
        return new UpdateToken($connector, new ValidateUpdateTokenData());
    }

    /**
     * @param Connector $connector
     * @return UpdateOrder
     */
    public static function returnUpdateOrderClass(Connector $connector)
    {
        return new UpdateOrder($connector, new ValidateUpdateOrderData());
    }

    /**
     * @param Connector $connector
     * @return GetAvailablePartPaymentCampaigns
     */
    public static function returnGetAvailablePartPaymentCampaignsClass(Connector $connector)
    {
        return new GetAvailablePartPaymentCampaigns($connector, new ValidateGetAvailablePartPaymentCampaignsData());
    }
}
