<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaConnector {

    public static function create() {
        $ch = new SveaCurlHandler();
//        $ch = curl_init('https://svea.com/checkout.aspx');
        return $ch;
    }
}