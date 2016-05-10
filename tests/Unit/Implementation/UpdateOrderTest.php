<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\UpdateOrder;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidateUpdateOrderData;

class UpdateOrderTest extends TestCase
{
    /**
     * @var UpdateOrder
     */
    protected $order;

    /**
     * @var ValidateUpdateOrderData|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateUpdateOrderData')->getMock();
        $this->order = new UpdateOrder($this->connectorMock, $this->validatorMock);
    }

    public function testMapData()
    {
        $updateOrder = $this->order;
        $updateOrder->mapData($this->inputUpdateData);

        $orderId = $this->inputUpdateData['id'];
        $this->assertEquals($orderId, $updateOrder->getOrderId());

        /**
         * @var CheckoutData $checkoutData
         */
        $checkoutData = $updateOrder->getCheckoutData();
        $orderLines = $this->inputCreateData['order_lines'];
        $items = $checkoutData->getCart()->getItems();

        foreach ($orderLines as $i => $orderLine) {
            /**
             * @var OrderRow $orderRow
             */
            $orderRow = $items[$i];

            $this->assertEquals($orderLine['articlenumber'], $orderRow->getArticleNumber());
            $this->assertEquals($orderLine['name'], $orderRow->getName());
            $this->assertEquals($orderLine['quantity'], $orderRow->getQuantity());
            $this->assertEquals($orderLine['unitprice'], $orderRow->getUnitPrice());
            $this->assertEquals($orderLine['vatpercent'], $orderRow->getVatPercent());
        }
    }

    public function testPrepareData()
    {
        $updateOrder = $this->order;
        $updateOrder->setCheckoutData($this->checkoutData);

        $updateOrder->prepareData();

        $requestBodyData = json_decode($updateOrder->getRequestBodyData(), true);

        $items = $requestBodyData['cart']['items'];
        /**
         * @var OrderRow[] $expectedItems
         */
        $expectedItems = $this->checkoutData->getCart()->getItems();
        $this->assertEquals($items[0]['articlenumber'], $expectedItems[0]->getArticleNumber());
        $this->assertEquals($items[0]['quantity'], $expectedItems[0]->getQuantity());

    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($fakeResponse));

        $updateOrder = $this->order;
        $updateOrder->setRequestBodyData(json_encode($this->checkoutData));
        $updateOrder->invoke();

        $this->assertEquals($fakeResponse, $updateOrder->getResponse());
    }

    public function testValidate()
    {
        $this->validatorMock->expects($this->once())
            ->method('validate');

        $getOrder = $this->order;

        $getOrder->validateData($this->inputCreateData);
    }
}
