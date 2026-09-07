<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateGetCallbackSubscriptionsData;

class ValidateGetCallbackSubscriptionsDataTest extends TestCase
{
    public function testAcceptsEmptyArray()
    {
        $validator = new ValidateGetCallbackSubscriptionsData();

        $validator->validate(array());
        $this->assertTrue(true);
    }
}
