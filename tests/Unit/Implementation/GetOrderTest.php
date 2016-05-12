<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\GetOrder;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateGetOrderData;

class GetOrderTest extends TestCase
{
    /**
     * @var ValidateGetOrderData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    /**
     * @var GetOrder
     */
    protected $order;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateGetOrderData')->getMock();
        $this->order = new GetOrder($this->connectorMock, $this->validatorMock);
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue(($fakeResponse)));

        $getOrder = $this->order;
        $getOrder->invoke();

        $this->assertEquals($fakeResponse, $getOrder->getResponse());
    }

    public function testValidate()
    {
        $orderId = 3;
        $this->validatorMock->expects($this->once())
            ->method('validate');
        $getOrder = $this->order;

        $getOrder->validateData($orderId);
    }
}
