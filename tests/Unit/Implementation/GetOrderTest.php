<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\GetOrder;
use Svea\Checkout\Tests\Unit\TestCase;

class GetOrderTest extends TestCase
{
    public function testMapData()
    {
        $getOrder = new GetOrder($this->connectorMock);

        $orderId = 2;

        $getOrder->mapData($orderId);

        $this->assertEquals($orderId, $getOrder->getOrderId());
    }

    public function testPrepareData()
    {
        $getOrder = new GetOrder($this->connectorMock);

        $orderId = 2;
        $getOrder->setOrderId($orderId);

        $getOrder->prepareData();

        $requestBodyData = json_decode($getOrder->getRequestBodyData(), true);

        $this->assertEquals($requestBodyData['Id'], $orderId);
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';

        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue(($fakeResponse)));

        $getOrder = new GetOrder($this->connectorMock);
        $getOrder->invoke();

        $this->assertEquals($fakeResponse, $getOrder->getResponse());
    }

    public function testValidateWithValidOrderId()
    {
        $getOrder = new GetOrder($this->connectorMock);

        $orderId = 2;

        $getOrder->validateData($orderId);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaInputValidationException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INPUT_VALIDATION_ERROR
     */
    public function testValidateWithInvalidOrderId()
    {
        $getOrder = new GetOrder($this->connectorMock);

        $orderId = 'two';

        $getOrder->validateData($orderId);
    }
}
