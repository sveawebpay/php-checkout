<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\ImplementationManager;
use Svea\Checkout\Tests\Unit\TestCase;

class ImplementationManagerTest extends TestCase
{
    public function testExecute()
    {
        $validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidationInterface')->getMock();
        /**
         * @var ImplementationManager|\PHPUnit_Framework_MockObject_MockObject $mock
         */
        $mock = $this->getMockBuilder('\Svea\Checkout\Implementation\ImplementationManager')
            ->setConstructorArgs(array($this->connectorMock, $validatorMock))
            ->setMethods(array('validateData', 'mapData', 'prepareData', 'invoke'))
            ->getMock();

        $mock->expects($this->once())
            ->method('validateData')
            ->with($this->equalTo($this->inputCreateData));

        $mock->expects($this->once())
            ->method('mapData')
            ->with($this->equalTo($this->inputCreateData));

        $mock->expects($this->once())
            ->method('prepareData');

        $mock->expects($this->once())
            ->method('invoke');

        $mock->execute($this->inputCreateData);
    }
}
