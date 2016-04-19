<?php

echo "sdfsfsdf <br /><br />";

echo __DIR__ . " <br />";
echo dirname(__DIR__) . " <br />";
echo dirname( dirname(__DIR__) ). " <br />";

$url =  dirname(__DIR__) . "\\vendor\\autoload.php";

$url = "vendor/autoload.php";

var_dump($url);

require_once $url;



//echo "<pre>" . print_r( get_declared_classes (), true ) . "</pre>";




$conn = new \Svea\Checkout\Transport\Connector([
    'merchantId' => '1',
    'secretWord' => 'SomeSecretWord',
    'url' => \Svea\Checkout\Transport\ConnectorInterface::SVE_TEST_URL
]);


