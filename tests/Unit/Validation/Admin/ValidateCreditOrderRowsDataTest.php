<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderRowsData;

class ValidateCreditOrderRowsDataTest extends TestCase
{
    /**
     * @var ValidateCreditOrderRowsData $validateUpdateOrderData
     */
    private $validateCreditOrderRow;

    /**
     * @var mixed $inputData
     */
    private $inputData;

    public function setUp()
    {
        parent::setUp();
        $this->validateCreditOrderRow = new ValidateCreditOrderRowsData();

        $this->inputData = array(
            "orderid" => 201,
            "deliveryid" => 1,
            "orderrowids" => array(3),
            "newcreditrow" => array(
                'unitPrice' => 5000
            )
        );
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutOrderId()
    {
        unset($this->inputData['orderid']);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdAsString()
    {
        $this->inputData['orderid'] = '204';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyOrderId()
    {
        $this->inputData['orderid'] = '';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithNullOrderId()
    {
        $this->inputData['orderid'] = null;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderIdAsDecimal()
    {
        $this->inputData['orderid'] = 204.5;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithOrderIdAsInteger()
    {
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }


    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutDeliveryId()
    {
        unset($this->inputData['deliveryid']);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithDeliveryIdAsString()
    {
        $this->inputData['deliveryid'] = '204';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyDeliveryId()
    {
        $this->inputData['deliveryid'] = '';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithNullDeliveryId()
    {
        $this->inputData['deliveryid'] = null;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithDeliveryIdAsDecimal()
    {
        $this->inputData['deliveryid'] = 204.5;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithDeliveryIdAsInteger()
    {
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithoutOrderRowIds()
    {
        unset($this->inputData['orderrowids']);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyOrderRowIdsAndWithoutNewCreditRow()
    {
        unset($this->inputData['newcreditrow']);
        $this->inputData['orderrowids'] = array();
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdsAsString()
    {
        $this->inputData['orderrowids'] = '204';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyOrderRowIds()
    {
        $this->inputData['orderrowids'] = '';
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithNullOrderRowIds()
    {
        $this->inputData['orderrowids'] = null;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdsAsDecimal()
    {
        $this->inputData['orderrowids'] = 204.5;
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdsAsEmptyArray()
    {
        $this->inputData['orderrowids'] = array();
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdAsEmptyArray()
    {
        $this->inputData['orderrowids'] = array();
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdAsString()
    {
        $this->inputData['orderrowids'] = array('1');
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithOrderRowIdAsDecimal()
    {
        $this->inputData['orderrowids'] = array(1.1);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithEmptyOrderRowId()
    {
        $this->inputData['orderrowids'] = array('');
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithOrderRowIdAsInteger()
    {
        $this->inputData['orderrowids'] = array(1);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutOrderRowIdsAndWithoutNewCreditRow()
    {
        unset($this->inputData['orderrowids']);
        unset($this->inputData['newcreditrow']);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    public function testValidateWithoutNewCreditRow()
    {
        unset($this->inputData['orderrowids']);
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithoutOrderRowIdsAndEmptyNewCreditRow()
    {
        unset($this->inputData['orderrowids']);
        $this->inputData['newcreditrow'] = array();
        $this->invokeMethod($this->validateCreditOrderRow, 'validate', array($this->inputData));
    }
}
