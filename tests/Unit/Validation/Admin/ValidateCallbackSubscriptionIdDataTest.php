<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCallbackSubscriptionIdData;

class ValidateCallbackSubscriptionIdDataTest extends TestCase
{
    public function testAcceptsCanonicalGuid()
    {
        $validator = new ValidateCallbackSubscriptionIdData();

        $validator->validate(array(
            'subscriptionid' => 'df7fd762-83ac-491a-3bb0-08dedc32520c'
        ));
        $this->assertTrue(true);
    }

    /**
     * @dataProvider invalidIdDataProvider
     */
    public function testRejectsInvalidSubscriptionId($data)
    {
        $this->expectException('\Svea\Checkout\Exception\SveaInputValidationException');

        $validator = new ValidateCallbackSubscriptionIdData();
        $validator->validate($data);
    }

    public function invalidIdDataProvider()
    {
        return array(
            'missing' => array(array()),
            'empty' => array(array('subscriptionid' => '')),
            'not a string' => array(array('subscriptionid' => 123)),
            'missing separators' => array(array('subscriptionid' => 'df7fd76283ac491a3bb008dedc32520c')),
            'invalid characters' => array(array('subscriptionid' => 'zf7fd762-83ac-491a-3bb0-08dedc32520c'))
        );
    }
}
