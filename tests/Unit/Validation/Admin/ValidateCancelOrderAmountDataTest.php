<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderAmountData;

class ValidateCancelOrderAmountDataTest extends TestCase
{
    public function testValidate()
    {
        $inputData = array(
            'orderid' => 201,
            'amount' => 1,
        );

        /**
         * @var ValidateCancelOrderAmountData|\PHPUnit_Framework_MockObject_MockObject $mock
         */
        $mock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateCancelOrderAmountData')
            ->setMethods(array('mustBeSet', 'mustBeInteger'))
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('mustBeSet');

        $mock->expects($this->exactly(2))
            ->method('mustBeInteger');

        $mock->validate($inputData);
    }
}
