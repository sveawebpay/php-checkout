<?php

require_once '../vendor/autoload.php';

$data = array(
    "purchase_country" => "gb",
    "purchase_currency" => "gbp",
    "locale" => "en-gb",
    "order_amount" => 10000,
    "order_tax_amount" => 2000,
    "order_lines" => array(
        array(
            "articlenumber" => "123456789",
            "name" => "Dator",
            "quantity" => 200,
            "unitprice" => 12300,
            "discountpercent" => 1000,
            "vatpercent" => 2500
        ),
        array(
            "articlenumber" => "123456789",
            "name" => "Dator",
            "quantity" => 200,
            "unitprice" => 12300,
            "discountpercent" => 1000,
            "vatpercent" => 2500
        )
    ),
    "merchant_urls" => array(
        "terms" => "http://www.merchant.com/toc",
        "checkout" => "http://www.merchant.com/checkout?klarna_order_id={checkout.order.id}",
        "confirmation" => "http://www.merchant.com/thank-you?klarna_order_id={checkout.order.id}",
        "push" => "http://www.merchant.com/create_order?klarna_order_id={checkout.order.id}"
    )
);

try {
    $merchantId = '1';
    $sharedSecret = 'sharedSecret';
    $baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

    $conn = \Svea\Checkout\Transport\Connector::create($merchantId, $sharedSecret, $baseUrl);

    $checkoutClient = new \Svea\Checkout\CheckoutClient($conn);
    $response = $checkoutClient->create($data);

    var_dump($response->getContent());
} catch (\Svea\Checkout\Exception\SveaApiException $ex) {
    var_dump("---------Api errors---------");
    var_dump($ex->getMessage());
} catch (\Svea\Checkout\Exception\SveaConnectorException $ex) {
    var_dump("---------Conn errors---------");
    var_dump($ex->getMessage());
} catch (Exception $ex) {
    var_dump("---------General errors---------");
    var_dump($ex->getMessage());
}
