<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\OrderFactory;
use Svea\Checkout\Tests\Unit\TestCase;

class OrderFactoryTest extends TestCase
{
    public function testReturnCreateOrderClass()
    {
        $co = OrderFactory::returnCreateOrderClass($this->connectorMock);
        $this->assertInstanceOf('\Svea\Checkout\Implementation\CreateOrder', $co);
    }

    public function testReturnGetOrderClass()
    {
        $co = OrderFactory::returnGetOrderClass($this->connectorMock);
        $this->assertInstanceOf('\Svea\Checkout\Implementation\GetOrder', $co);
    }

    public function testReturnUpdateOrderClass()
    {
        $co = OrderFactory::returnUpdateOrderClass($this->connectorMock);
        $this->assertInstanceOf('\Svea\Checkout\Implementation\UpdateOrder', $co);
    }
}
