<?php

// include the Svea Checkout autoload file if you are using Composer
//require_once '../vendor/autoload.php';

// - without composer
require_once '../../include.php';

/*
 * Example of getting the order delivery information
 *
 * */
$data = array(
	'id' => 201,
	'deliveryId' => 1
);

/*
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be STAGE_BASE_URL and PROD_BASE_URL
 * */
$checkoutMerchantId = '1';
$checkoutSecret = 'sharedSecret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL;

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
	$response = $checkoutClient->getOrderDelivery($data);
	echo "<pre>" . print_r($response, true);

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
