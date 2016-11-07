<?php

namespace Svea\Checkout\Tests\Unit\Implementation\Admin;

use Svea\Checkout\Implementation\Admin\CancelOrder;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderData;

class CancelOrderTest extends TestCase
{
    /**
     * @var CancelOrder
     */
    protected $cancelOrderAmount;

    /**
     * @var ValidateCancelOrderData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateCancelOrderData')
            ->getMock();
        $this->cancelOrderAmount = new CancelOrder($this->connectorMock, $this->validatorMock);
    }

    public function testPrepareData()
    {
        $inputData = array(
            'orderid' => 1,
            'amount' => 15000
        );
        $this->cancelOrderAmount->prepareData($inputData);

        $requestModel = $this->cancelOrderAmount->getRequestModel();
        $requestBodyData = json_decode($requestModel->getBody(), true);

        $this->assertEquals(Request::METHOD_PATCH, $requestModel->getMethod());
        $this->assertEquals($inputData['amount'], $requestBodyData['amount']);
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($fakeResponse));

        $createOrder = $this->cancelOrderAmount;
        $createOrder->setRequestModel($this->requestModel);
        $createOrder->invoke();

        $this->assertEquals($fakeResponse, $createOrder->getResponse());
    }

    public function testValidate()
    {
        $this->validatorMock->expects($this->once())
            ->method('validate');

        $getOrder = $this->cancelOrderAmount;

        $getOrder->validateData($this->inputCreateData);
    }
}
