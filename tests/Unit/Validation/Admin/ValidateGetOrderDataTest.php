<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderData;

class ValidateGetOrderDataTest extends TestCase
{
    public function testValidateWithOrderIdIntAsIntiger()
    {
        $orderId = 1234;
        $validateGetOrder = new ValidateGetOrderData();
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdIntAsString()
    {
        $orderId = '1234';
        $validateGetOrder = new ValidateGetOrderData();
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $orderId = 'svea';
        $validateGetOrder = new ValidateGetOrderData();
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $orderId = '';
        $validateGetOrder = new ValidateGetOrderData();
        $validateGetOrder->validate($orderId);
    }
}
