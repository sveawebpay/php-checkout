<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class Svea_Connector {

    public static function create() {
        $ch = curl_init('https://svea.com/checkout.aspx');
        return $ch;
    }
}