<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderAmountData;

class ValidateCancelOrderAmountDataTest extends TestCase
{
    /**
     * @var ValidateCancelOrderAmountData $validateUpdateOrderData
     */
    private $validateCancelOrderAmount;

    /**
     * @var mixed $inputData
     */
    private $inputData;

    public function setUp()
    {
        parent::setUp();
        $this->validateCancelOrderAmount = new ValidateCancelOrderAmountData();

        $this->inputData = array(
            'orderid' => 204,
            'amount' => 500
        );
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutOrderId()
    {
        unset($this->inputData['orderid']);
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdAsString()
    {
        $this->inputData['orderid'] = '204';
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyOrderId()
    {
        $this->inputData['orderid'] = '';
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithNullOrderId()
    {
        $this->inputData['orderid'] = null;
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdAsDecimal()
    {
        $this->inputData['orderid'] = 204.5;
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    public function testValidateWithOrderIdAsInteger()
    {
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutAmount()
    {
        unset($this->inputData['amount']);
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithAmountAsString()
    {
        $this->inputData['amount'] = '204';
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyAmount()
    {
        $this->inputData['amount'] = '';
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithNullAmount()
    {
        $this->inputData['amount'] = null;
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithAmountAsDecimal()
    {
        $this->inputData['amount'] = 204.5;
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }

    public function testValidateWithAmountAsInteger()
    {
        $this->invokeMethod($this->validateCancelOrderAmount, 'validate', array($this->inputData));
    }
}
