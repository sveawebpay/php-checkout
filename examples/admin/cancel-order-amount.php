<?php

/**
 * By specifying a higher amount than the current order cancelled amount then the order cancelled amount will increase,
 * assuming the order has the action "CanCancelAmount".
 * The delta between the new CancelledAmount and the former CancelledAmount will be cancelled.
 *
 *
 * Include Library
 *
 * If you use Composer, include the autoload.php file from vendor folder
 * require_once '../vendor/autoload.php';
 *
 * If you do not use Composer, include the include.php file from root of the project
 * require_once '../../include.php';
 */

require_once '../../include.php';

$checkoutMerchantId = 100001;
$checkoutSecret = "3862e010913d7c44f104ddb4b2881f810b50d5385244571c3327802e241140cc692522c04aa21c942793c8a69a8e55ca7b6131d9ac2a2ae2f4f7c52634fe30d1";

/**
 * @var string $baseUrl
 * Base Url for SVEA Api. Can be TEST_BASE_URL or PROD_BASE_URL
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
        "orderId" => 204,
//        "amount" => 5000
    );

    /**
     * Possible Exceptions are:
     * \Svea\Checkout\Exception\SveaInputValidationException - if $orderId is missing
     * \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
     *      some error occurred with data validation on API side
     * \Exception - for any other error
     */
    $response = $checkoutClient->cancelOrderAmount($data);

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
