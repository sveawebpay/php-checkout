<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class ConnectionUnitTest extends PHPUnit_Framework_TestCase {

    function test_initialize_connection() {
        $connection = SveaCheckout::connect();
        $this->assertTrue(isset($connection));//returns cURL handle on success, FALSE on errors
    }
}