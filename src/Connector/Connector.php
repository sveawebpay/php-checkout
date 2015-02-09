<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaConnector {

    public static function create() {
        return new SveaCurlHandler();
    }

}