<?php

namespace Svea\Checkout\Tests\Unit\Validation\Admin;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\Admin\ValidateCallbackSubscriptionData;

class ValidateCallbackSubscriptionDataTest extends TestCase
{
    /**
     * @dataProvider validAddDataProvider
     */
    public function testAddAcceptsValidData($data)
    {
        $validator = new ValidateCallbackSubscriptionData();

        $validator->validate($data);
        $this->assertTrue(true);
    }

    public function validAddDataProvider()
    {
        $data = array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        );

        return array(
            'secret omitted' => array($data),
            'secret supplied' => array(array_merge($data, array('secret' => 'callback-secret'))),
            'empty secret' => array(array_merge($data, array('secret' => ''))),
            'new event name' => array(array_merge($data, array('events' => array('Future.Event'))))
        );
    }

    /**
     * @dataProvider invalidAddDataProvider
     */
    public function testAddRejectsInvalidData($data)
    {
        $this->expectException('\Svea\Checkout\Exception\SveaInputValidationException');

        $validator = new ValidateCallbackSubscriptionData();
        $validator->validate($data);
    }

    public function invalidAddDataProvider()
    {
        $valid = array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        );

        return array(
            'missing callback URI' => array(array('events' => $valid['events'])),
            'HTTP callback URI' => array(array_merge($valid, array('callbackuri' => 'http://merchant.example'))),
            'invalid callback URI' => array(array_merge($valid, array('callbackuri' => 'not-a-url'))),
            'non-string callback URI' => array(array_merge($valid, array('callbackuri' => 123))),
            'missing events' => array(array('callbackuri' => $valid['callbackuri'])),
            'empty events' => array(array_merge($valid, array('events' => array()))),
            'events is not an array' => array(array_merge($valid, array('events' => 'CheckoutOrder.Created'))),
            'empty event name' => array(array_merge($valid, array('events' => array('')))),
            'blank event name' => array(array_merge($valid, array('events' => array('  ')))),
            'non-string event' => array(array_merge($valid, array('events' => array(123)))),
            'invalid UTF-8 event' => array(array_merge($valid, array('events' => array("\xB1\x31")))),
            'non-string secret' => array(array_merge($valid, array('secret' => null))),
            'invalid UTF-8 secret' => array(array_merge($valid, array('secret' => "\xB1\x31")))
        );
    }

    public function testUpdateRequiresSubscriptionId()
    {
        $this->expectException('\Svea\Checkout\Exception\SveaInputValidationException');

        $validator = new ValidateCallbackSubscriptionData(true);
        $validator->validate(array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        ));
    }

    public function testUpdateAcceptsEmptySecret()
    {
        $validator = new ValidateCallbackSubscriptionData(true);
        $validator->validate(array(
            'subscriptionid' => 'df7fd762-83ac-491a-3bb0-08dedc32520c',
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created'),
            'secret' => ''
        ));

        $this->assertTrue(true);
    }

    public function testUpdateAcceptsOmittedSecret()
    {
        $validator = new ValidateCallbackSubscriptionData(true);
        $validator->validate(array(
            'subscriptionid' => 'df7fd762-83ac-491a-3bb0-08dedc32520c',
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        ));

        $this->assertTrue(true);
    }
}
