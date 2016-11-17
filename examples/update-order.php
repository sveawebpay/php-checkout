<?php

// include the Svea Checkout autoload file if you are using Composer
require_once '../vendor/autoload.php';

// - without composer
//require_once '../include.php';

/*
 * Example of updating the order and getting the response data
 *
 * */

// - Add required information for creating order
$data = array(
    "orderId" => 1669,
    "cart" => array(
        "items" => array(
            array(
                "articleNumber" => "123456",
                "name" => "Dator",
                "quantity" => 200,
                "unitPrice" => 12300,
                "discountPercent" => 1000,
                "vatPercent" => 2500,
                "temporaryReference" => "230"
            ),
            array(
                "type" => "shipping_fee",
                "articleNumber" => "658475",
                "name" => "Shipping Fee Updated",
                "quantity" => 100,
                "unitPrice" => 4900,
                "vatPercent" => 2500,
                "temporaryReference" => "231"
            )
        )
    )
);

/*
 * Connector parameters are:
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be TEST_BASE_URL and PROD_BASE_URL
 * */
$checkoutMerchantId = '100001';
$checkoutSecret = '3862e010913d7c44f104ddb4b2881f810b50d5385244571c3327802e241140cc692522c04aa21c942793c8a69a8e55ca7b6131d9ac2a2ae2f4f7c52634fe30d1';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;
/*
 *  Initialize updating the order and receive the response data
 *  Possible Exceptions are:
 *  - \Svea\Checkout\Exception\SveaInputValidationException - if some of fields is missing
 *  - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 *      some error occurred with data validation on API side
 *  - \Exception - for any other error
 *
 * */
try {
    /*
     * Create Connector object
     *
     * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
     * some of fields $merchantId, $sharedSecret and $baseUrl is missing
     * */
    $conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

    // Create Checkout client with created Connector object
    $checkoutClient = new \Svea\Checkout\CheckoutClient($conn);
    $response = $checkoutClient->update($data);

    /*
     * Format of returned response array
     *
     * Response:
     *  - MerchantSettings
     *      - TermsUri
     *      - CheckoutUri
     *      - ConfirmationUri
     *      - PushUri
     *  - Cart
     *      - Items [..] / list of items
     *          - ArticleNumber
     *          - Name
     *          - Quantity
     *          - UnitPrice
     *          - DiscountPercent
     *          - VatPercent
     *          - Unit
     *          - TemporaryReference
     *  - Customer
     *  - ShippingAddress
     *  - BillingAddress
     *  - Gui
     *      - Layout
     *      - Snippet
     *  - Locale
     *  - Currency
     *  - CountryCode
     *  - PresetValues
     *  - OrderId
     *  - Status
     * */
    $orderId = $response['Response']['OrderId'];
    $guiSnippet = $response['Response']['Gui']['Snippet'];
    $orderStatus = $response['Response']['Status'];
} catch (\Svea\Checkout\Exception\SveaApiException $ex) {
    var_dump("--------- Api errors ---------");
    var_dump($ex->getMessage());
} catch (\Svea\Checkout\Exception\SveaConnectorException $ex) {
    var_dump("--------- Conn errors ---------");
    var_dump($ex->getMessage());
} catch (\Svea\Checkout\Exception\SveaInputValidationException $ex) {
    var_dump("--------- Input data errors ---------");
    var_dump($ex->getMessage());
} catch (Exception $ex) {
    var_dump("--------- General errors ---------");
    var_dump($ex->getMessage());
}
