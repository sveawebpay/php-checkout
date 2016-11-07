<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\Admin\ValidateGetOrderData;
use Svea\Checkout\Validation\Admin\ValidateAddOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderData;
use Svea\Checkout\Validation\Admin\ValidateGetDataFromLink;
use Svea\Checkout\Validation\Admin\ValidateDeliverOrderData;
use Svea\Checkout\Validation\Admin\ValidateUpdateOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderRowsData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderCreditsData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderDeliveryData;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderAmountData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderAmountData;

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
     * @return GetOrderAddresses
     */
    public static function returnGetOrderAddressesClass(Connector $connector)
    {
        return new GetOrderAddresses($connector, new ValidateGetOrderAddressesData());
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
     * @return CancelOrder
     */
    public static function returnCancelOrderClass(Connector $connector)
    {
        return new CancelOrder($connector, new ValidateCancelOrderData());
    }

    /**
     * @param Connector $connector
     * @return CancelOrderRow
     */
    public static function returnCancelOrderRowClass(Connector $connector)
    {
        return new CancelOrderRow($connector, new ValidateCancelOrderRowData());
    }

    /**
     * @param Connector $connector
     * @return CreditOrderAmount
     */
    public static function returnCreditOrderAmountClass(Connector $connector)
    {
        return new CreditOrderAmount($connector, new ValidateCreditOrderAmountData());
    }

    /**
     * @param Connector $connector
     * @return GetOrderCredit
     */
    public static function returnGetOrderCreditClass(Connector $connector)
    {
        return new GetOrderCredit($connector, new ValidateGetOrderCreditsData());
    }

    /**
     * @param Connector $connector
     * @return CreditOrderRows
     */
    public static function returnCreditOrderRowsClass(Connector $connector)
    {
        return new CreditOrderRows($connector, new ValidateCreditOrderRowsData());
    }

    /**
     * @param Connector $connector
     * @return AddOrderRow
     */
    public static function returnAddOrderRowClass(Connector $connector)
    {
        return new AddOrderRow($connector, new ValidateAddOrderRowData());
    }

    /**
     * @param Connector $connector
     * @return UpdateOrderRow
     */
    public static function returnUpdateOrderRowClass(Connector $connector)
    {
        return new UpdateOrderRow($connector, new ValidateUpdateOrderRowData());
    }

    /**
     * @param Connector $connector
     * @return GetDataFromLink
     */
    public static function returnGetDataFromLinkClass(Connector $connector)
    {
        return new GetDataFromLink($connector, new  ValidateGetDataFromLink());
    }
}
