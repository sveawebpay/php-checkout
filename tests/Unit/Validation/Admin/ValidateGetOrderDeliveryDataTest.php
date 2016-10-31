<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderDeliveryData;

class ValidateGetOrderDeliveryDataTest extends TestCase
{
    public function testValidateWithOrderIdIntAsString()
    {
        $orderId = '1234';
        $validateGetOrder = new ValidateGetOrderDeliveryData();
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $orderId = 'svea';
        $validateGetOrder = new ValidateGetOrderDeliveryData();
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $orderId = '';
        $validateGetOrder = new ValidateGetOrderDeliveryData();
        $validateGetOrder->validate($orderId);
    }
}
