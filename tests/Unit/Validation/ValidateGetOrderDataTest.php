<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateGetOrderData;

class ValidateGetOrderDataTest extends TestCase
{
    public function testValidateWithOrderIdIntAsString()
    {
        $orderId = '1234';
        $validateGetOrder = new ValidateGetOrderData($orderId);
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $orderId = 'svea';
        $validateGetOrder = new ValidateGetOrderData($orderId);
        $validateGetOrder->validate($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $orderId = '';
        $validateGetOrder = new ValidateGetOrderData($orderId);
        $validateGetOrder->validate($orderId);
    }
}
