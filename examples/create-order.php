<?php

require_once '../vendor/autoload.php';

$data = array(
    "purchase_country" => "SE",
    "purchase_currency" => "SEK",
    "locale" => "sv-SE",
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
        )
    ),
    "merchant_urls" => array(
        "terms" => "http://localhost:51898/terms",
        "checkout" => "http://localhost:51925/",
        "confirmation" => "http://localhost:51925/checkout/confirm",
        "push" => "https://svea.com/push.aspx?sid=123&svea_order=123"
    )
);

try {
    $merchantId = '1';
    $sharedSecret = 'sharedSecret';
    $baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

    $conn = new \Svea\Checkout\Transport\Connector($merchantId, $sharedSecret, $baseUrl);

    $checkoutClient = new \Svea\Checkout\CheckoutClient($conn);
    $response = $checkoutClient->create($data);

    print_r($response['Gui']['Snippet']);
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
