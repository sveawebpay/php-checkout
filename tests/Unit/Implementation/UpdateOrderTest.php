<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\UpdateOrder;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateUpdateOrderData;

class UpdateOrderTest extends TestCase
{
    /**
     * @var UpdateOrder
     */
    protected $updateOrder;

    /**
     * @var ValidateUpdateOrderData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateUpdateOrderData')->getMock();
        $this->updateOrder = new UpdateOrder($this->connectorMock, $this->validatorMock);
    }

    public function testPrepareData()
    {
        $this->updateOrder->prepareData($this->inputUpdateData);

        $requestBodyData = json_decode($this->updateOrder->getRequestBodyData(), true);

        $items = $requestBodyData['cart']['items'];

        $expectedItems = $this->inputUpdateData['cart']['items'];
        $this->assertEquals($items[0]['articlenumber'], $expectedItems[0]['articlenumber']);
        $this->assertEquals($items[0]['quantity'], $expectedItems[0]['quantity']);

    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($fakeResponse));

        $updateOrder = $this->updateOrder;
        $updateOrder->setRequestBodyData(json_encode($this->inputUpdateData));
        $updateOrder->invoke();

        $this->assertEquals($fakeResponse, $updateOrder->getResponse());
    }

    public function testValidate()
    {
        $this->validatorMock->expects($this->once())
            ->method('validate');

        $getOrder = $this->updateOrder;

        $getOrder->validateData($this->inputCreateData);
    }
}
