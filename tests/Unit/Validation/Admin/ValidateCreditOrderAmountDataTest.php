<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCreditOrderAmountData;

class ValidateCreditOrderAmountDataTest extends TestCase
{
    public function testValidate()
    {
        $inputData = array(
            "orderid"    => 204,
            "deliveryid" => 1,
            "amount"     => 2000,
        );

        /**
         * @var ValidateCreditOrderAmountData|\PHPUnit_Framework_MockObject_MockObject $mock
         */
        $mock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateCreditOrderAmountData')
            ->setMethods(array('mustBeArray', 'mustBeInteger'))
            ->getMock();

        $mock->expects($this->exactly(3))
            ->method('mustBeInteger');

        $mock->validate($inputData);
    }

    public function testValidateWithOrderRowIds()
    {
        $inputData = array(
            'orderid'    => 204,
            'deliveryid' => 1,
            'amount'     => 2000,
            'orderrowids' => array(1,2)
        );

        /**
         * @var ValidateCreditOrderAmountData|\PHPUnit_Framework_MockObject_MockObject $mock
         */
        $mock = $this->getMockBuilder('\Svea\Checkout\Validation\Admin\ValidateCreditOrderAmountData')
            ->setMethods(array('mustBeArray', 'mustBeInteger'))
            ->getMock();

        $mock->expects($this->exactly(3))
            ->method('mustBeInteger');

        $mock->expects($this->exactly(1))
            ->method('mustBeArray');

        $mock->validate($inputData);
    }
}
