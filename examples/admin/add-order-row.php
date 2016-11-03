<?php

// include the Svea Checkout autoload file if you are using Composer
//require_once '../vendor/autoload.php';

// - without composer
require_once '../../include.php';

/*
 * Example of getting the order information
 *
 * */

// Order ID from created order
$data = array(
    "orderId"       => 201,        // required - Long  filed (Specified Checkout order for cancel amount)
    "orderRow" => array(
        "ArticleNumber" => "prod-01",
        "Name"          => "someProd",
        "Quantity"      => 300,
        "UnitPrice"     => 5000,
        //"DiscountPercent" => "", // optional 0-100
        "VatPercent"    => 0,       // required - 0, 6, 12, 25
        "Unit"          => "pc"           // optional st, pc, kg, etc.
    )
);

/*
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 * */
$checkoutMerchantId = '1';
$checkoutSecret     = 'sharedSecret';
$baseUrl            = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

/*
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 * */
$checkoutMerchantId = '1';
$checkoutSecret     = 'sharedSecret';
$baseUrl            = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

/*
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 * */
$conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutAdminClient($conn);


/*
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 * */
$checkoutMerchantId = '1';
$checkoutSecret     = 'sharedSecret';
$baseUrl            = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

/*
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 * */
$conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutAdminClient($conn);

/*
 *  Initialize getting the order information
 *  Possible Exceptions are:
 *  - \Svea\Checkout\Exception\SveaInputValidationException - if $orderId is missing
 *  - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 *      some error occurred with data validation on API side
 *  - \Exception - for any other error
 *
 * */
try {
    $response = $checkoutClient->addOrderRow($data);

    var_dump($response);

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