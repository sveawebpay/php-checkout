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
        $this->inputCreateData = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithoutRequiredFields()
    {
        unset($this->inputCreateData['locale']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithEmptyStringFiled()
    {
        $this->inputCreateData['locale'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    public function testValidateGeneralDataWithFalseValueField()
    {
        $this->inputCreateData['locale'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    public function testValidateGeneralDataWithZeroValueField()
    {
        $this->inputCreateData['locale'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithNoArrayData()
    {
        $this->inputCreateData['merchant_urls'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithoutRequiredFields()
    {
        unset($this->inputCreateData['merchant_urls']['checkout']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithEmptyStringFiled()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithFalseValueField()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithZeroValueField()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemsWithNoArrayData()
    {
        $this->inputCreateData['order_lines'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItems', array($this->inputCreateData));
    }

    public function testValidateOrderItemsWithEmptyArray()
    {
        $this->inputCreateData['order_lines'] = array();

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItems', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithNoArrayData()
    {
        $orderItemData = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyArrayData()
    {
        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);
        $orderItemData = array();

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithoutRequiredFields()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        unset($orderItemData['name']);

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyStringFiled()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = '';

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithFalseValueField()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = false;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithZeroValueField()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = 0;

        $validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);

        $this->invokeMethod($validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }
}
