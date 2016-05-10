<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateUpdateOrderData;

class ValidateUpdateOrderDataTest extends TestCase
{
    /**
     * @var ValidateUpdateOrderData $validateUpdateOrderData
     */
    private $validateUpdateOrderData;

    public function setUp()
    {
        parent::setUp();
        $this->validateUpdateOrderData = new ValidateUpdateOrderData($this->inputUpdateData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithUnsetField()
    {
        unset($this->inputUpdateData['id']);
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithEmptyStringFiled()
    {
        $this->inputUpdateData['id'] = '';
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderIdWithFalseValueField()
    {
        $this->inputUpdateData['id'] = false;
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }

    public function testValidateOrderIdWithZeroValueField()
    {
        $this->inputUpdateData['id'] = 1230;
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderId', array($this->inputUpdateData));
    }


    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemsWithNoArrayData()
    {
        $this->inputUpdateData['order_lines'] = '';
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    public function testValidateOrderItemsWithEmptyArray()
    {
        $this->inputUpdateData['order_lines'] = array();
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    public function testValidateOrderItemsWithArray()
    {
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItems', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithNoArrayData()
    {
        $this->inputUpdateData = '';
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyArrayData()
    {
        $this->inputUpdateData = array();
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($this->inputUpdateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithoutRequiredFields()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        unset($orderItemData['name']);
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyStringFiled()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = '';
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithFalseValueField()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = false;
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithZeroValueField()
    {
        $orderItemData = $this->inputUpdateData['order_lines'][0];
        $orderItemData['name'] = 0;
        $this->invokeMethod($this->validateUpdateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateWithValidData()
    {
        $this->validateUpdateOrderData->validate($this->inputUpdateData);
    }
}
