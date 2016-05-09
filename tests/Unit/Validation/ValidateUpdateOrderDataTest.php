<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateUpdateOrderData;

class ValidateUpdateOrderDataTest extends TestCase
{
    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithUnsetField()
    {
        unset($this->inputUpdateData['id']);

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithEmptyStringFiled()
    {
        $this->inputUpdateData['id'] = '';

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithFalseValueField()
    {
        $this->inputUpdateData['id'] = false;

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    public function testValidateOrderIdWithZeroValueField()
    {
        $this->inputUpdateData['id'] = 1230;

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }


    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemsWithNoArrayData()
    {
        $this->inputUpdateData['order_lines'] = '';

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    public function testValidateOrderItemsWithEmptyArray()
    {
        $this->inputUpdateData['order_lines'] = array();

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    public function testValidateOrderItemsWithArray()
    {
        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithNoArrayData()
    {
        $this->inputUpdateData = '';

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyArrayData()
    {
        $this->inputUpdateData = array();

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithoutRequiredFields()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        unset($orderItemData['name']);

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyStringFiled()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = '';

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithFalseValueField()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = false;

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithZeroValueField()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = 0;

        $validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);

        $this->invokeMethod($validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }
}
