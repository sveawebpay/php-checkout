<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData;

class ValidateGetOrderAddressDataTest extends TestCase
{
    /**
     * @var ValidateGetOrderAddressesData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        $this->validatorMock = new ValidateGetOrderAddressesData();
    }

    public function testValidateWithOrderIdIntAsInteger()
    {
        $data = array('id' => 1234);

        $this->validatorMock->validate($data);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdIntAsString()
    {
        $data = array('id' => '1234');

        $this->validatorMock->validate($data);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdString()
    {
        $data = array('id' => 'svea');

        $this->validatorMock->validate($data);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyString()
    {
        $data = array('id' => '');

        $this->validatorMock->validate($data);
    }

    public function testValidateWithEmptyAddressId()
    {
        $data = array(
            'id' => 1,
            'addressid' => ''
        );

        $this->validatorMock->validate($data);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithAddressIdAsString()
    {
        $data = array(
            'id' => 1,
            'addressid' => 'wrongId'
        );

        $this->validatorMock->validate($data);
    }

    public function testValidateWithAddressIdAsInt()
    {
        $data = array(
            'id' => 1,
            'addressid' => 3
        );

        $this->validatorMock->validate($data);
    }
}