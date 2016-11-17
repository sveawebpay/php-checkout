<?php

// include the Svea Checkout autoload file if you are using Composer
//require_once '../vendor/autoload.php';

// - without composer
require_once '../include.php';

/**
 * Example of creating the order and getting the response data
 */

// Add required information for creating order
$data = array(
    "countryCode" => "SE",
    "currency" => "SEK",
    "locale" => "sv-SE",
    "clientOrderNumber" => rand(70000, 270000),
    "cart" => array(
        "items" => array(
            array(
                "articleNumber" => "1234567",
                "name" => "Dator",
                "quantity" => 200,
                "unitPrice" => 12300,
                "discountPercent" => 1000,
                "vatPercent" => 2500,
                'temporaryReference' => "230"
            ),
            array(
                "articleNumber" => "7654321",
                "name" => "Fork",
                "quantity" => 300,
                "unitPrice" => 15800,
                "discountPercent" => 2000,
                "vatPercent" => 2500,
                'temporaryReference' => "231"
            ),
            array(
                "type" => "shipping_fee",
                "articleNumber" => "",
                "name" => "Shipping fee",
                "quantity" => 100,
                "unitPrice" => 4900,
                "vatPercent" => 2500
            )
        )
    ),
    "presetValues" => array(
        array(
            "typeName" => "emailAddress",
            "value" => "test@sveaekonomi.se",
            "isReadonly" => true
        ),
        array(
            "typeName" => "postalCode",
            "value" => "11850",
            "isReadonly" => true
        )
    ),
    "merchantSettings" => array(
        "termsUri" => "http://localhost:51898/terms",
        "checkoutUri" => "http://localhost:51925/",
        "confirmationUri" => "http://localhost:51925/checkout/confirm",
        "pushUri" => "https://svea.com/push.aspx?sid=123&svea_order=123"
    )
);

/**
 * Create connector for given
 * - Checkout Merchant Id - unique merchant ID for checkout
 * - Checkout Secret - Checkout Secret string between Svea and merchant
 * - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 */
$checkoutMerchantId = "100001";
$checkoutSecret = "3862e010913d7c44f104ddb4b2881f810b50d5385244571c3327802e241140cc692522c04aa21c942793c8a69a8e55ca7b6131d9ac2a2ae2f4f7c52634fe30d1";
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;


/**
 * Initialize creating the order and receive the response data
 * Possible Exceptions are:
 * - \Svea\Checkout\Exception\SveaInputValidationException - if some of fields is missing
 * - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 * some error occurred with data validation on API side
 * - \Exception - for any other error
 */
try {
    /**
     * Create Connector object
     *
     * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
     * some of fields $checkoutMerchantId, $checkoutSecret and $baseUrl is missing
     */
    $conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

    // Create Checkout client with created Connector object
    $checkoutClient = new \Svea\Checkout\CheckoutClient($conn);

    $response = $checkoutClient->create($data);

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
     */

    $orderId = $response['OrderId'];
    $guiSnippet = $response['Gui']['Snippet'];
    $orderStatus = $response['Status'];
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
