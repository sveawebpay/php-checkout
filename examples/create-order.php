<?php

// include the Svea Checkout autoload file if you are not using Composer
require_once '../vendor/autoload.php';

/*
 * Example of creating the order and getting the response data
 *
 * */

// - Add required information for creating order
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
        ),
        array(
            "articlenumber" => "987654321",
            "name" => "Fork",
            "quantity" => 300,
            "unitprice" => 15800,
            "discountpercent" => 2000,
            "vatpercent" => 2500
        ),
        array(
            "type" => "shipping_fee",
            "articlenumber" => "SHIPPING",
            "name" => "Shipping fee",
            "quantity" => 100,
            "unitprice" => 4900,
            "vatpercent" => 2500
        ),

    ),
    "merchant_urls" => array(
        "terms" => "http://localhost:51898/terms",
        "checkout" => "http://localhost:51925/",
        "confirmation" => "http://localhost:51925/checkout/confirm",
        "push" => "https://svea.com/push.aspx?sid=123&svea_order=123"
    )
);


/*
 * Create connector for given
 *  - Merchant Id - unique merchant ID
 *  - Shared Secret - Shared Secret string between Svea and merchant
 *  - Base Url for SVEA Api. Can be TEST_BASE_URL and PROD_BASE_URL
 * */
$merchantId = '1';
$sharedSecret = 'sharedSecret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

/*
 * Create Connector object
 *
 * Exception \Svea\Checkout\Exception\SveaConnectorException will be returned if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 * */
$conn = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutClient($conn);

/*
 *  Initialize creating the order and receive the response data
 *  Possible Exceptions are:
 *  - \Svea\Checkout\Exception\SveaInputValidationException - if some of fields is missing
 *  - \Svea\Checkout\Exception\SveaApiException - is there is some problem with api connection or
 *      some error occurred with data validation on API side
 *  - \Exception - for any other error
 *
 * */
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
 *          - DiscountPercent
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
 * */

$orderId = $response['OrderId'];

$guiSnippet = $response['Gui']['Snippet'];

$orderStatus = $response['Status'];
