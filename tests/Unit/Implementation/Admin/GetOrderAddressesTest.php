<?php

namespace Svea\Checkout\Tests\Unit\Implementation\Admin;

use Svea\Checkout\Implementation\Admin\GetOrderAddresses;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData;

class GetOrderAddressesTest extends TestCase
{
    /**
     * @var ValidateGetOrderAddressesData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    /**
     * @var GetOrder
     */
    protected $getOrder;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateGetOrderAddressesData')->getMock();
        $this->getOrder = new GetOrderAddresses($this->connectorMock, $this->validatorMock);
    }

    public function testPrepareData()
    {
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');

        $this->getOrder->prepareData(5);

        $requestModel = $this->getOrder->getRequestModel();

        $this->assertInstanceOf('\Svea\Checkout\Model\Request', $requestModel);
        $this->assertEquals(Request::METHOD_GET, $requestModel->getMethod());
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue(($fakeResponse)));

        $this->requestModel->setGetMethod();
        $this->requestModel->setBody(null);
        $this->getOrder->setRequestModel($this->requestModel);

        $this->getOrder->invoke();

        $this->assertEquals($fakeResponse, $this->getOrder->getResponse());
    }

    public function testValidate()
    {
        $orderId = array(
            'id' => 1,
            'addressId' => 1
        );

        $this->validatorMock->expects($this->once())
            ->method('validate');

        $this->getOrder->validateData($orderId);
    }
}
