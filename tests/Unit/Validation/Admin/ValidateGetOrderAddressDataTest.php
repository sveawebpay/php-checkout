<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData;

class ValidateGetOrderAddressDataTest extends TestCase
{
    /**
     * @var ValidateGetOrderAddressesData $validateUpdateOrderData
     */
    private $validateGetOrderAddress;

    /**
     * @var mixed $inputData
     */
    private $inputData;

    public function setUp()
    {
        $this->validateGetOrderAddress = new ValidateGetOrderAddressesData();

        $this->inputData = array(
            'orderid'   => 201,
            'addressid' => 1
        );
    }

    public function testValidateWithOrderIdIntAsInteger()
    {
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithMissingOrderId()
    {
        unset($this->inputData['orderid']);
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdIntAsString()
    {
        $this->inputData['orderid'] = '201';
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $this->inputData['orderid'] = 'svea';
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $this->inputData['orderid'] = '';

        $this->validateGetOrderAddress->validate($this->inputData);
    }

    public function testValidateWithEmptyAddressId()
    {
        unset($this->inputData['addressid']);
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithAddressIdAsString()
    {
        $this->inputData['addressid'] = 'wrongId';
        $this->validateGetOrderAddress->validate($this->inputData);
    }

    public function testValidateWithAddressIdAsInt()
    {
        $this->inputData['addressid'] = 3;
        $this->validateGetOrderAddress->validate($this->inputData);
    }
}
