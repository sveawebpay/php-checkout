<?php

// include the Svea Checkout autoload file if you are not using Composer
require_once '../vendor/autoload.php';


/*
 * Example of creating order and getting response data
 *
 * Possible Throw Exceptions are:
 *  - \Svea\Checkout\Exception\SveaApiException when ...
 *  - \Svea\Checkout\Exception\SveaInputValidationException
 *  - \Exception
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
 *  - Merchant Id
 *  - Shared Secret
 *  - Base Url for SVEA Api
 * */
$merchantId = '1';
$sharedSecret = 'sharedSecret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

/*
 * Create Connector object
 *
 * Possible Throw Exception is \Svea\Checkout\Exception\SveaConnectorException which will return exception if
 * some of fields $merchantId, $sharedSecret and $baseUrl is missing
 * */
$conn = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);

// Create Checkout client with created Connector object
$checkoutClient = new \Svea\Checkout\CheckoutClient($conn);

// Initialize creating order and receive response data
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
