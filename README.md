# PHP Integration Package API for Svea Checkout
Version 1.0.0

## Index
* [1. Introduction](#introduction)
* [2. Setup](#setup)
* [3. Create order](#create-order)
* [4. Get order](#get-order)
* [5. Update order](#update-order)

* [2. Build and Configuration](https://github.com/sveawebpay/dotnet-integration/tree/master#2-build-and-configuration)
* [3. Create order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-create-order)
* [3. Get order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-get-order)
* [3. Update order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-update-order)

[<< To top](https://github.com/sveawebpay/dotnet-integration/tree/master#cnet-integration-package-api-for-svea-checkout)



### 1. Introduction <a id="introduction"></a>
Svea Checkout Library is library that allows you easy integration with Svea Checkout Api. This library is dedicated for
Creating Order, Getting Order information and for Updating Order information.

This file contains an overview and examples how to implement and use the Svea Checkout Library in your project.


### 2. Setup <a id="setup"></a>
Svea Checkout Library can be implemented into project by composer or by copying this library directly into project.

**Via Composer:** if you are using project with composer, you can add library:

by command line with command

    Composer require svea/checkout

or by adding next part into your composer.json file and do ` composer update `

    {
        "require": {
            "svea/checkout": "dev-master"
        }
    }

**Normally:** if you have project that does not use Composer, you can download it from git and copy it into
your project into desired folder. The thing that left is to include autoload.php file into your working files.


### 3. Create Order <a id="create-order"></a>

#####Include the library
```php
include 'vendor/autoload.php'

// or by include classes

use \Svea\Checkout\Transport\Connector;
// and
use \Svea\Checkout\Implementation\ChechoutClient;
```

#####Create Connector
Necessary fields for creating Connector are: merchantId, sharedSecret and base Api url.
```php
$merchantId = '1';
$sharedSecret = 'sharedSecret';
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

$conn = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);
```

#####Creating Order
CheckoutClient object is entry point for creating, getting and updating the order.
To create CheckoutClient object you need to provide Connector object as constructor property.

```php
$checkoutClient = new \Svea\Checkout\CheckoutClient($conn);
```

Information about new order must be provide as list. Required fields are given in table below:

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| merchantSettings              |	*        | array     | List of Merchant urls |
| cart                          |	*        | array     | List of cart items that should be passed through 'items' list|
| locale                        |	*        | string    | Language Culture Name (eg. "sv-SE")|
| countrycode                   |	*        | string    | Client country code as ISO 3166 (eg. "SE") |
| currency                      |	*        | string    | Currency as ISO 4217 eg. "SEK"|



| merchantSettings             | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| termsuri                     |	*      | string    | See... @TODO |
| checkouturi                  |	*      | string    | See... @TODO |
| confirmationuri              |	*      | string    | See... @TODO |
| pushuri                      |	*      | string    | See... @TODO |



| cart > items                 | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| type                         |	*       | string    | See... @TODO |
| articlenumber                |	*       | string    | See... @TODO |
| name                         |	*       | string    | See... @TODO |
| quantity                     |	*       | int       | See... @TODO |
| unitprice                    |	*       | int       | See... @TODO |
| discountprice                |	*       | int       | See... @TODO |
| vatpercent                   |	*       | int       | See... @TODO |


Now, when CheckoutClient is created we can create order. Calling Api for creating order is done by passing data to
method _create_.

```php
// - Add required information for creating order
$data = array(
    "countrycode" => "SE",
    "currency" => "SEK",
    "locale" => "sv-SE",
    "cart" => array(
        "items" => array(
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

$response = $checkoutClient->create($data);
```

You can display Checkout Gui on your page simply by printing Gui data from response;

```php
echo $response['Gui']['Snippet']
```


Response is a list of data returned from API. Response example is given below.

```
Array
(
    [MerchantSettings] => Array
        (
            [TermsUri] => http://localhost:51898/terms
            [CheckoutUri] => http://localhost:51925/
            [ConfirmationUri] => http://localhost:51925/checkout/confirm
            [PushUri] => https://svea.com/push.aspx?sid=123&svea_order=123
        )

    [Cart] => Array
        (
            [Items] => Array
                (
                    [0] => Array
                        (
                            [ArticleNumber] => 123456789
                            [Name] => Dator
                            [Quantity] => 200
                            [UnitPrice] => 12300
                            [DiscountPercent] => 1000
                            [VatPercent] => 2500
                            [Unit] =>
                        )
                    [1] => Array
                        (
                            [ArticleNumber] => SHIPPING
                            [Name] => Shipping Fee Updated
                            [Quantity] => 100
                            [UnitPrice] => 4900
                            [DiscountPercent] => 0
                            [VatPercent] => 2500
                            [Unit] =>
                        )
                )
         )
    [Customer] =>
    [ShippingAddress] =>
    [BillingAddress] =>
    [Gui] => Array
        (
            [Layout] => desktop
            [Snippet] =>
        )
    [Locale] => sv-SE
    [Currency] =>
    [CountryCode] =>
    [PresetValues] =>
    [OrderId] => 9
    [Status] => Created
)
```


### 4. Get Order <a id="get-order"></a>




### 5. Update Order <a id="update-order"></a>



is used to create a new order with properly formatted order data containing merchant settings, locale, country, authorization and cart.
It is also possible to preset values to be displayed in the checkout.

Returns a full Data object containing the order and the GUI, and a Http response with Http status code 201 (created). See... @TODO
If request is not successful it returns Http status code 400 (Bad request) and Http header "ErrorMessage" containing the details.

| Parameters IN                 | Required  | Type      | Description  |
|---------------------------    |-----------|-----------|--------------|
| merchantSettings              |	*   | array     | See... @TODO |
| cart                          |	*   | array     | List of items See... @TODO |
| locale                        |	*   | string    | Language Culture Name (eg. "sv-SE")|
| countrycode                   |	*   | string    | Client country code as ISO 3166 (eg. "SE" |
| currency                      |	*   | string    | Currency as ISO 4217 eg. "SEK"|




### 1. Create order  <a id="create-order"></a>
is used to create a new order with properly formatted order data containing merchant settings, locale, country, authorization and cart.
It is also possible to preset values to be displayed in the checkout.

Returns a full Data object containing the order and the GUI, and a Http response with Http status code 201 (created). See... @TODO
If request is not successful it returns Http status code 400 (Bad request) and Http header "ErrorMessage" containing the details.

| Parameters IN                 | Required  | Type      | Description  |
|---------------------------    |-----------|-----------|--------------|
| merchantSettings              |	*   | array     | See... @TODO |
| cart                          |	*   | array     | List of items See... @TODO |
| locale                        |	*   | string    | Language Culture Name (eg. "sv-SE")|
| countrycode                   |	*   | string    | Client country code as ISO 3166 (eg. "SE" |
| currency                      |	*   | string    | Currency as ISO 4217 eg. "SEK"|

@TODO See ***LINK*** for full example

```php
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

```
### 1. Get order
is used to get an order.

Returns a full Data object containing the order and the GUI.
If request is not successful it returns Http status code 400 (Bad request) and Http header "ErrorMessage" containing the details.

| Parameters IN                 | Required  | Type      | Description  |
|---------------------------    |-----------|-----------|--------------|
| orderId                       |	*   | Long      | Id returned when creating order |

@TODO See ***LINK*** for full example

```php
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

```
### 1. Create order
is used to create a new order with properly formatted order data containing merchant settings, locale, country, authorization and cart.
It is also possible to preset values to be displayed in the checkout.

Returns a full Data object containing the order and the GUI, and a Http response with Http status code 201 (created).
If request is not successful it returns Http status code 400 (Bad request) and Http header "ErrorMessage" containing the details.

| Parameters IN                 | Required  | Type      | Description  |
|---------------------------    |-----------|-----------|--------------|
| merchantSettings              |	*   | array     | See... @TODO |
| cart                          |	*   | array     | List of items See... @TODO |
| locale                        |	*   | string    | Language Culture Name (eg. "sv-SE")|
| countrycode                   |	*   | string    | Client country code as ISO 3166 (eg. "SE" |
| currency                      |	*   | string    | Currency as ISO 4217 eg. "SEK"|

@TODO See ***LINK*** for full example

```php
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

```

