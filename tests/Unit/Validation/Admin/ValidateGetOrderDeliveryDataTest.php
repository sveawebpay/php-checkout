<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderDeliveryData;

class ValidateGetOrderDeliveryDataTest extends TestCase
{
    /**
     * @var ValidateGetOrderDeliveryData $validateUpdateOrderData
     */
    private $validateGetOrderDelivery;

    /**
     * @var mixed $inputData
     */
    private $inputData;

    public function setUp()
    {
        parent::setUp();
        $this->validateGetOrderDelivery = new ValidateGetOrderDeliveryData();

        $this->inputData = array(
            'orderid'    => 204,
            'deliveryid' => 1
        );
    }

    public function testValidateWithOrderIdIntAsInteger()
    {
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdIntAsString()
    {
        $this->inputData['orderid'] = '1234';
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $this->inputData['orderid'] = 'svea';
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $this->inputData['orderid'] = '';
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithMissingOrderId()
    {
        unset($this->inputData['orderid']);
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    public function testValidateWithMissingDeliveryId()
    {
        unset($this->inputData['deliveryid']);
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyDeliveryId()
    {
        $this->inputData['deliveryid'] = '';
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithDeliveryIdAsString()
    {
        $this->inputData['deliveryid'] = 'wrongId';
        $this->validateGetOrderDelivery->validate($this->inputData);
    }

    public function testValidateWithDeliveryIdAsInt()
    {
        $this->validateGetOrderDelivery->validate($this->inputData);
    }
}
