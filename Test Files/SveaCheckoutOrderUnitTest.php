<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class SveaCheckoutOrderUnitTest extends PHPUnit_Framework_TestCase {

    function test_get_order_object() {
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $this->assertEquals(get_class($order),'SveaCheckoutOrder');//returns cURL handle on success, FALSE on errors
    }
}