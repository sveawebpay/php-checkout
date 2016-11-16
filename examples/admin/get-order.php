<?php

// include the Svea Checkout autoload file if you are using Composer
//require_once '../vendor/autoload.php';

// - without composer
require_once '../../include.php';

/**
 * Example of getting the order information
 */

// Order ID from created order
$orderId = 51729;

/**
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 */
$checkoutMerchantId = "100001";
$checkoutSecret = "3862e010913d7c44f104ddb4b2881f810b50d5385244571c3327802e241140cc692522c04aa21c942793c8a69a8e55ca7b6131d9ac2a2ae2f4f7c52634fe30d1";
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

/**
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 */
$conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutAdminClient($conn);

/**
 * Initialize getting the order information
 *  Possible Exceptions are:
 *  - \Svea\Checkout\Exception\SveaInputValidationException - if $orderId is missing
 *  - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 *      some error occurred with data validation on API side
 *  - \Exception - for any other error
 *
 */
try {
    $response = $checkoutClient->getOrder($orderId);
    print_r($response);

} catch (\Svea\Checkout\Exception\SveaApiException $ex) {
    var_dump("--------- Api errors ---------");
    var_dump('Error message -> ' . $ex->getMessage());
    var_dump('Error code -> ' . $ex->getCode());
} catch (\Svea\Checkout\Exception\SveaConnectorException $ex) {
    var_dump("--------- Conn errors ---------");
    var_dump('Error message -> ' . $ex->getMessage());
    var_dump('Error code -> ' . $ex->getCode());
} catch (\Svea\Checkout\Exception\SveaInputValidationException $ex) {
    var_dump("--------- Input data errors ---------");
    var_dump('Error message -> ' . $ex->getMessage());
    var_dump('Error code -> ' . $ex->getCode());
} catch (Exception $ex) {
    var_dump("--------- General errors ---------");
    var_dump('Error message -> ' . $ex->getMessage());
    var_dump('Error code -> ' . $ex->getCode());
}
