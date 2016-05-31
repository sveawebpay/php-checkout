<?php

// include the Svea Checkout autoload file if you are using Composer
require_once '../vendor/autoload.php';

// - without composer
//require_once '../include.php';

/**
 * Example of creating the order and getting the response data
 */

// Add required information for creating order
$data = array(
    "countrycode" => "SE",
    "currency" => "SEK",
    "locale" => "sv-SE",
    "cart" => array(
        "items" => array(
            array(
                "articlenumber" => "1234567",
                "name" => "Dator",
                "quantity" => 200,
                "unitprice" => 12300,
                "discountpercent" => 1000,
                "vatpercent" => 2500
            ),
            array(
                "articlenumber" => "7654321",
                "name" => "Fork",
                "quantity" => 300,
                "unitprice" => 15800,
                "discountpercent" => 2000,
                "vatpercent" => 2500
            ),
            array(
                "type" => "shipping_fee",
                "articlenumber" => "",
                "name" => "Shipping fee",
                "quantity" => 100,
                "unitprice" => 4900,
                "vatpercent" => 2500
            )
        )
    ),
    "merchantSettings" => array(
        "termsuri" => "http://localhost:51898/terms",
        "checkouturi" => "http://localhost:51925/",
        "confirmationuri" => "http://localhost:51925/checkout/confirm",
        "pushuri" => "https://svea.com/push.aspx?sid=123&svea_order=123"
    )
);

/**
 * Create connector for given
 * - Merchant Id - unique merchant ID
 * - Shared Secret - Shared Secret string between Svea and merchant
 * - Base Url for SVEA Api. Can be TEST_BASE_URL and PROD_BASE_URL
 */
$merchantId = '1';
$sharedSecret = 'sharedSecret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

/**
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 */
$conn = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutClient($conn);

/**
 * Initialize creating the order and receive the response data
 * Possible Exceptions are:
 * - \Svea\Checkout\Exception\SveaInputValidationException - if some of fields is missing
 * - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 * some error occurred with data validation on API side
 * - \Exception - for any other error
 */
try {
    $response = $checkoutClient->create($data);
    
    /*
     * Format of returned response array
     *
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
