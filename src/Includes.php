<?php

/**
 * Autoload all classes
 */

if (!defined('SVEA_REQUEST_DIR'))
    define('SVEA_REQUEST_DIR', dirname(__FILE__));

foreach (glob(SVEA_REQUEST_DIR . "/Request/*.php") as $config)
    include_once($config);
foreach (glob(SVEA_REQUEST_DIR . "/Order/*.php") as $config)
    include_once($config);
