<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaConnector {

    public static $sveaCurlHandler;

    public static function create() {
        self::$sveaCurlHandler = new SveaCurlHandler();
        return  self::$sveaCurlHandler;
    }

    public static function getOrderUrl() {
        return self::$sveaCurlHandler->getOrderUrl();
    }

}