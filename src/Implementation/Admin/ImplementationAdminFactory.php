<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\Admin\ValidateDeliverOrderWithLowerAmountData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderData;
use Svea\Checkout\Validation\Admin\ValidateAddOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderData;
use Svea\Checkout\Validation\Admin\ValidateGetDataFromLink;
use Svea\Checkout\Validation\Admin\ValidateDeliverOrderData;
use Svea\Checkout\Validation\Admin\ValidateGetTaskData;
use Svea\Checkout\Validation\Admin\ValidateUpdateOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderRowData;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderRowsData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderCreditsData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderDeliveryData;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderAmountData;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderRowsWithFeeData;
use Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData;
use Svea\Checkout\Validation\Admin\ValidateReplaceOrderRowsData;
use Svea\Checkout\Validation\Admin\ValidateCallbackSubscriptionData;
use Svea\Checkout\Validation\Admin\ValidateCallbackSubscriptionIdData;
use Svea\Checkout\Validation\Admin\ValidateGetCallbackSubscriptionsData;

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
     * @return DeliverOrderWithLowerAmount
     */
    public static function returnDeliverOrderWithLowerAmountClass(Connector $connector)
    {
        return new DeliverOrderWithLowerAmount($connector, new ValidateDeliverOrderWithLowerAmountData());
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
     * @return GetTask
     */
    public static function returnGetTaskClass(Connector $connector)
    {
        return new GetTask($connector, new ValidateGetTaskData());
    }

    /**
     * @param Connector $connector
     * @param bool $isCancelAmount
     * @return CancelOrder
     */
    public static function returnCancelOrderClass(Connector $connector, $isCancelAmount = false)
    {
        return new CancelOrder($connector, new ValidateCancelOrderData($isCancelAmount), $isCancelAmount);
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
     * @param bool $isNewCreditRow
     * @return CreditOrderRows
     */
    public static function returnCreditOrderRowsClass(Connector $connector, $isNewCreditRow = false)
    {
        return new CreditOrderRows($connector, new ValidateCreditOrderRowsData($isNewCreditRow), $isNewCreditRow);
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
     * @return ReplaceOrderRows
     */
    public static function returnReplaceOrderRowsClass(Connector $connector)
    {
        return new ReplaceOrderRows($connector, new ValidateReplaceOrderRowsData());
    }

    /**
     * @param Connector $connector
     * @return CreditOrderRowsWithFee
     */
    public static function returnCreditOrderRowsWithFeeClass(Connector $connector)
    {
        return new CreditOrderRowsWithFee($connector, new ValidateCreditOrderRowsWithFeeData());
    }

    /**
     * @param Connector $connector
     * @return GetCallbackSubscriptions
     */
    public static function returnGetCallbackSubscriptionsClass(Connector $connector)
    {
        return new GetCallbackSubscriptions($connector, new ValidateGetCallbackSubscriptionsData());
    }

    /**
     * @param Connector $connector
     * @return GetCallbackSubscription
     */
    public static function returnGetCallbackSubscriptionClass(Connector $connector)
    {
        return new GetCallbackSubscription($connector, new ValidateCallbackSubscriptionIdData());
    }

    /**
     * @param Connector $connector
     * @return AddCallbackSubscription
     */
    public static function returnAddCallbackSubscriptionClass(Connector $connector)
    {
        return new AddCallbackSubscription($connector, new ValidateCallbackSubscriptionData());
    }

    /**
     * @param Connector $connector
     * @return UpdateCallbackSubscription
     */
    public static function returnUpdateCallbackSubscriptionClass(Connector $connector)
    {
        return new UpdateCallbackSubscription($connector, new ValidateCallbackSubscriptionData(true));
    }

    /**
     * @param Connector $connector
     * @return VerifyCallbackSubscription
     */
    public static function returnVerifyCallbackSubscriptionClass(Connector $connector)
    {
        return new VerifyCallbackSubscription($connector, new ValidateCallbackSubscriptionIdData());
    }

    /**
     * @param Connector $connector
     * @return RemoveCallbackSubscription
     */
    public static function returnRemoveCallbackSubscriptionClass(Connector $connector)
    {
        return new RemoveCallbackSubscription($connector, new ValidateCallbackSubscriptionIdData());
    }
}
