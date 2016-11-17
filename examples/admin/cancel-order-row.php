<?php

/**
 * Get Svea Checkout order from admin API.
 * This method is used to get the entire order with all its relevant information.
 * Including its deliveries, rows, credits and addresses
 */


/**
 * Include Library
 *
 * If you use Composer, include the autoload.php file from vendor folder
 * require_once '../vendor/autoload.php';
 *
 * If you do not use Composer, include the include.php file from root of the project
 * require_once '../../include.php';
 */
require_once '../../include.php';

/**
 * @var integer $checkoutMerchantId
 * Unique merchant ID
 */
$checkoutMerchantId = 100001;

/**
 * @var string $checkoutSecret
 * Shared Secret string between Svea and merchant
 */
$checkoutSecret = "3862e010913d7c44f104ddb4b2881f810b50d5385244571c3327802e241140cc692522c04aa21c942793c8a69a8e55ca7b6131d9ac2a2ae2f4f7c52634fe30d1";

/**
 * @var string $baseUrl
 * Base Url for SVEA Api. Can be TEST_BASE_URL and PROD_BASE_URL
 */
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

try {
    /**
     * Create Connector object
     *
     * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
     * some of fields $merchantId, $sharedSecret and $baseUrl is missing
     */
    $conn = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);
    $checkoutClient = new \Svea\Checkout\CheckoutAdminClient($conn);

    $data = array(
        "orderId" => 7322, // required - Long  filed (Specified Checkout order for cancel amount)
        "orderRowId" => 1, // required - Long - Id of the specified row.
    );

    /**
     * Possible Exceptions are:
     * \Svea\Checkout\Exception\SveaInputValidationException - if $orderId is missing
     * \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
     *      some error occurred with data validation on API side
     * \Exception - for any other error
     */
    $response = $checkoutClient->cancelOrderRow($data);

    if ($response === '') {
        print_r('Success cancel amount');
    }

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
