<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCurlHandler {

    private $handler = null;

    public function __construct() {
        $this->handler = curl_init('https://svea.com/checkout.aspx');
        return $this->handler;
    }
}