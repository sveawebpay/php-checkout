<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class ConnectorUnitTest extends PHPUnit_Framework_TestCase {

    function test_initialize_connector() {
        $connector = Svea_Connector::create();
        $this->assertTrue(isset($connector));//returns cURL handle on success, FALSE on errors
    }
}