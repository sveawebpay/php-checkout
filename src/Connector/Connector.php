<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaConnector {

//    public static $sveaCurlHandler;

    public static function create() {
        $curl = new SveaCurlHandler();
        return new SveaCheckoutConnector($curl);
//        self::$sveaCurlHandler = new SveaCurlHandler();
//        return $this;
    }



//    public static function getOrderUrl() {
//        return self::$sveaCurlHandler->getOrderUrl();
//    }

}