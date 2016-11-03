<?php

// include Svea Checkout library if you are using Composer
//require_once '../vendor/autoload.php';

// include Svea Checkout library without composer
require_once '../../include.php';

// Input data for this admin action
$data = array(
    "orderId" => 201, // required - Long  Id of the specified order
    "orderRowId" => 1, // required - Long - Id of the specified order rows that will be updated.

    /**
     * Order row data
     */

    "orderRowData" => array(
        /**
         * String - Articlenumber as a string, can contain letters and numbers.
         * Limit - Maximum 256 characters
         */
        "articleNumber" => "123456",

        /**
         * String - Article name
         * Limit - 1-40 characters
         */
        "name" => "Dator",

        /**
         * Integer - Quantity of the product.
         * Limit - 1-9 digits
         */
        "quantity" => 200,

        /**
         * Integer - Price of product including VAT
         * Limit - 1-13 digits, can be negative. Minor currency
         */
        "unitPrice" => 12300,

        /**
         * Integer - The discount percent of the product
         * Limit - 0-100
         */
        "discountPercent" => 50,

        /**
         * Integer - The VAT percentage of the current product
         * Limit - Valid VAT percentage for that country. Minor currency
         */
        "vatPercent" => 6,

        /**
         * String - The unit type e.g. "st", "pc", "kg", etc.
         * Limit - 0-4 characters
         */
        "Unit" => "230"
    )
);

/**
 * Create connector
 * Shared Secret - Shared Secret string between Svea and merchant
 * Base Url for SVEA Checkout admin Api. Can be TEST_ADMIN_BASE_URL and PROD_ADMIN_BASE_URL
 */
$checkoutMerchantId = '1';
$checkoutSecret = 'Shared secret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

/**
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 */
$conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);

// Create Checkout admin client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutAdminClient($conn);

/**
 * Initialize Update order row
 */
try {
    $response = $checkoutClient->updateOrderRow($data);
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
