<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\CreateOrder;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateCreateOrderData;

class CreateOrderTest extends TestCase
{
    /**
     * @var CreateOrder
     */
    protected $createOrder;

    /**
     * @var ValidateCreateOrderData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateCreateOrderData')->getMock();
        $this->createOrder = new CreateOrder($this->connectorMock, $this->validatorMock);
    }

    public function testPrepareData()
    {
        $this->createOrder->prepareData($this->inputCreateData);

        $requestBodyData = json_decode($this->createOrder->getRequestBodyData(), true);

        $this->assertEquals($requestBodyData['locale'], $this->inputCreateData['locale']);
        $this->assertEquals($requestBodyData['countrycode'], $this->inputCreateData['countrycode']);
        $this->assertEquals($requestBodyData['currency'], $this->inputCreateData['currency']);

        $items = $requestBodyData['cart']['items'];

        $expectedItems = $requestBodyData['cart']['items'];
        $this->assertEquals($items[0]['articlenumber'], $expectedItems[0]['articlenumber']);
        $this->assertEquals($items[0]['quantity'], $expectedItems[0]['quantity']);

        $merchantSettings = $requestBodyData['merchantSettings'];
        $expectedMerchantSettings = $this->inputCreateData['merchantSettings'];
        $this->assertEquals($merchantSettings['termsuri'], $expectedMerchantSettings['termsuri']);
        $this->assertEquals($merchantSettings['checkouturi'], $expectedMerchantSettings['checkouturi']);
        $this->assertEquals($merchantSettings['confirmationuri'], $expectedMerchantSettings['confirmationuri']);
        $this->assertEquals($merchantSettings['pushuri'], $expectedMerchantSettings['pushuri']);
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($fakeResponse));

        $createOrder = $this->createOrder;
        $createOrder->setRequestBodyData(json_encode($this->inputCreateData));
        $createOrder->invoke();

        $this->assertEquals($fakeResponse, $createOrder->getResponse());
    }

    public function testValidate()
    {
        $this->validatorMock->expects($this->once())
            ->method('validate');

        $getOrder = $this->createOrder;

        $getOrder->validateData($this->inputCreateData);
    }
}
