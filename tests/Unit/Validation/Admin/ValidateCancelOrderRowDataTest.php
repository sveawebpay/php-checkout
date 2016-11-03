<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCancelOrderRowData;

class ValidateCancelOrderRowDataTest extends TestCase
{
    public function testValidate()
    {
        $inputData = array(
            'orderid' => 201,
            'orderrowid' => 1,
        );

        /**
         * @var ValidateCancelOrderRowData|\PHPUnit_Framework_MockObject_MockObject $mock
         */
        $mock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateCancelOrderRowData')
            ->setMethods(array('mustBeSet', 'mustBeInteger'))
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('mustBeSet');

        $mock->expects($this->exactly(2))
            ->method('mustBeInteger');

        $mock->validate($inputData);
    }
}
