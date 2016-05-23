<?php

/*
 *
 * This file is used if you want to autoload project classes
 * without using Composer for autoloading classes
 *
 * */


/**
 * Return desired class
 * @param string $className
 */
function __autoload_checkout_connection_classes($className)
{
    $filename = str_replace('Svea\\Checkout\\', '', $className);

    $fullPath = __DIR__ . '\\src\\' . $filename . ".php";

    if (file_exists($fullPath)) {
        include_once $fullPath;
    }
}

spl_autoload_register('__autoload_checkout_connection_classes');