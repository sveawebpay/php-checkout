<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateCreateOrderData;

class ValidateCreateOrderDataTest extends TestCase
{
    /**
     * @var ValidateCreateOrderData $validateUpdateOrderData
     */
    private $validateCreateOrderData;

    public function setUp()
    {
        parent::setUp();
        $this->validateCreateOrderData = new ValidateCreateOrderData($this->inputCreateData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithNoArrayData()
    {
        $this->inputCreateData = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithoutRequiredFields()
    {
        unset($this->inputCreateData['locale']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateGeneralDataWithEmptyStringFiled()
    {
        $this->inputCreateData['locale'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    public function testValidateGeneralDataWithFalseValueField()
    {
        $this->inputCreateData['locale'] = false;
        $this->invokeMethod($this->validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    public function testValidateGeneralDataWithZeroValueField()
    {
        $this->inputCreateData['locale'] = 0;
        $this->invokeMethod($this->validateCreateOrderData, 'validateGeneralData', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithNoArrayData()
    {
        $this->inputCreateData['merchant_urls'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithoutData()
    {
        unset($this->inputCreateData['merchant_urls']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithoutRequiredFields()
    {
        unset($this->inputCreateData['merchant_urls']['checkout']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithEmptyStringFiled()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithFalseValueField()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = false;
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithZeroValueField()
    {
        $this->inputCreateData['merchant_urls']['checkout'] = 0;
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemsWithNoArrayData()
    {
        $this->inputCreateData['order_lines'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItems', array($this->inputCreateData));
    }

    public function testValidateOrderItemsWithValidData()
    {
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItems', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithNoArrayData()
    {
        $orderItemData = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyArrayData()
    {
        $orderItemData = array();
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithoutRequiredFields()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        unset($orderItemData['name']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderItemWithEmptyStringFiled()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithFalseValueField()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = false;
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateOrderItemWithZeroValueField()
    {
        $orderItemData = $this->inputCreateData['order_lines'][0];
        $orderItemData['name'] = 0;
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderItem', array($orderItemData));
    }

    public function testValidateWithValidData()
    {
        $this->validateCreateOrderData->validate($this->inputCreateData);
    }



    public function testValitation()
    {
        $val = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateCreateOrderData')->getMock();

        $val->expects($this->once())
            ->method('validateGeneralData');

        $val->expects($this->once())
            ->method('validateMerchant');

        $val->expects($this->once())
            ->method('validateOrderItems');

        $val->validate(array());
    }
}
