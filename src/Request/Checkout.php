<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCheckout {

    public static function connect() {
        return new SveaCheckoutConnection();
    }
}