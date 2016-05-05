<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateCreateOrderData;

class ValidateCreateOrderDataTest extends TestCase
{
    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithNoArrayData()
    {
        $this->inputData = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithoutRequiredFields()
    {
        unset($this->inputData['locale']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithEmptyStringFiled()
    {
        $this->inputData['locale'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputData));
    }

    public function testValidateGeneralDataWithFalseValueField()
    {
        $this->inputData['locale'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputData));
    }

    public function testValidateGeneralDataWithZeroValueField()
    {
        $this->inputData['locale'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithNoArrayData()
    {
        $this->inputData['merchant_urls'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithoutRequiredFields()
    {
        unset($this->inputData['merchant_urls']['checkout']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithEmptyStringFiled()
    {
        $this->inputData['merchant_urls']['checkout'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputData));
    }

    public function testValidateMerchantWithFalseValueField()
    {
        $this->inputData['merchant_urls']['checkout'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputData));
    }

    public function testValidateMerchantWithZeroValueField()
    {
        $this->inputData['merchant_urls']['checkout'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemsWithNoArrayData()
    {
        $this->inputData['order_lines'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItems', array($this->inputData));
    }

    public function testValidateOrderItemsWithEmptyArray()
    {
        $this->inputData['order_lines'] = array();

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItems', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithNoArrayData()
    {
        $orderItemData = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyArrayData()
    {
        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);
        $orderItemData = array();

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithoutRequiredFields()
    {
        $orderItemData = $this->inputData['order_lines'][0];
        unset($orderItemData['name']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyStringFiled()
    {
        $orderItemData = $this->inputData['order_lines'][0];
        $orderItemData['name'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithFalseValueField()
    {
        $orderItemData = $this->inputData['order_lines'][0];
        $orderItemData['name'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithZeroValueField()
    {
        $orderItemData = $this->inputData['order_lines'][0];
        $orderItemData['name'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }
}
