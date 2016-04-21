<?php

require_once 'vendor/autoload.php';


$data = array(
    "purchase_country" => "gb",
    "purchase_currency" => "gbp",
    "locale" => "en-gb",
    "order_amount" => 10000,
    "order_tax_amount" => 2000,
    "order_lines" => array(
        array(
            "type" => "physical",
            "reference" => "123050",
            "name" => "Tomatoes",
            "quantity" => 10,
            "quantity_unit" => "kg",
            "unit_price" => 600,
            "tax_rate" => 2500,
            "total_amount" => 6000,
            "total_tax_amount" => 1200
        ),
        array(
            "type" => "physical",
            "reference" => "543670",
            "name" => "Bananas",
            "quantity" => 1,
            "quantity_unit" => "bag",
            "unit_price" => 5000,
            "tax_rate" => 2500,
            "total_amount" => 4000,
            "total_discount_amount" => 1000,
            "total_tax_amount" => 800
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
    $conn = \Svea\Checkout\Transport\Connector::create(
        'merchant1',
        'SomeSecretWord',
        \Svea\Checkout\Transport\Connector::TEST_BASE_URL
    );
    $cc = new \Svea\Checkout\CheckoutClient($conn);
    $response = $cc->create($data);
    var_dump($response->getContent());
} catch (\Svea\Checkout\Transport\Exception\SveaApiException $ex) {
    var_dump("---------Api errors---------");
    var_dump($ex->getMessage());
} catch (\Svea\Checkout\Transport\Exception\SveaConnectorException $e) {
    var_dump("---------Conn errors---------");
    var_dump($e->getMessage());
} catch (Exception $e) {
    var_dump("---------General errors---------");
    var_dump($e->getMessage());
}

