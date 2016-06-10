<?php

namespace Svea\Checkout\Tests\Unit\Validation;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateCreateOrderData;

class ValidateCreateOrderDataTest extends TestCase
{
    /**
     * @var ValidateCreateOrderData $validateCreateOrderData
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
    public function testValidateMerchantWithoutData()
    {
        unset($this->inputCreateData['merchantSettings']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithNoArrayData()
    {
        $this->inputCreateData['merchantSettings'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithoutRequiredFields()
    {
        unset($this->inputCreateData['merchantSettings']['checkouturi']);
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateMerchantWithEmptyStringFiled()
    {
        $this->inputCreateData['merchantSettings']['checkouturi'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithFalseValueField()
    {
        $this->inputCreateData['merchantSettings']['checkouturi'] = false;
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    public function testValidateMerchantWithZeroValueField()
    {
        $this->inputCreateData['merchantSettings']['checkouturi'] = 0;
        $this->invokeMethod($this->validateCreateOrderData, 'validateMerchant', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderCartWithCartNoArrayData()
    {
        $this->inputCreateData['cart'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderCart', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderCartWithItemsNoArrayData()
    {
        $this->inputCreateData['cart']['items'] = '';
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderCart', array($this->inputCreateData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderCartWithCartEmptyArrayData()
    {
        $this->inputCreateData['cart'] = array();
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderCart', array($this->inputCreateData));
    }

    public function testValidateOrderCartWithValidData()
    {
        $this->invokeMethod($this->validateCreateOrderData, 'validateOrderCart', array($this->inputCreateData));
    }

    public function testValidateWithValidData()
    {
        $this->validateCreateOrderData->validate($this->inputCreateData);
    }

    public function testValidateOrderClientOrderNumberWithGoodData()
    {
        $this->invokeMethod($this->validateCreateOrderData, 'validateClientOrderNumber', array($this->inputCreateData) );
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderClientOrderNumberWithMissingData()
    {
        unset($this->inputCreateData['clientordernumber']);

        $this->invokeMethod($this->validateCreateOrderData, 'validateClientOrderNumber', array($this->inputCreateData) );
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateOrderClientOrderNumberWithBadData()
    {
        $this->inputCreateData['clientordernumber'] = '123-das-321';

        $this->invokeMethod($this->validateCreateOrderData, 'validateClientOrderNumber', array($this->inputCreateData) );
    }
}
