# PHP Checkout library for Svea Checkout
Version 1.0.0

## Index
* [1. Setup](#1-setup)
* [2. Create a Connector](#2-create-a-connector)
* [3. Create order](#3-create-order)
* [4. Get order](#4-get-order)
* [5. Update order](#5-update-order)
* [6. Response](#6-response)
* [7. Data structures](#7-data-structures)
* [8. Sub System Info](#8-subsysteminfo)


## Introduction
The checkout offers a complete solution with a variety of payment methods. The underlying systems for the checkout is our
paymentPlan, invoice, account payments. Also including our own payment gateway with PCI level 1 for card payments. 
The checkout supports both B2C and B2B payments, fast customer identification and caches customers behaviour. 
For administration of orders, you can either implement it in your own project, or use our new admin interface.

The library provides entry points to Create Order, Get Order and for Updating Order.

### 1. Setup

#### 1.1 Install with [**Composer**](https://getcomposer.org/)

In command line
```bash

    Composer require svea/checkout

```

or add this part to your composer.json

```json
    {
        "require": {
            "svea/checkout": "dev-master"
        }
    }
```
and run command ` composer update ` in the console

#### 1.2 Install without composer
You can also download and unzip the project and upload it to your server.

### 2 Create a Connector
You use a connector object as parameter when creating a CheckoutClient request.
Parameters for creating Connector are: merchantId, sharedSecret and base Api url.

```php
// include the library
include 'vendor/autoload.php';

// without composer
// require_once 'include.php';

$merchantId = '1';
$sharedSecret = 'sharedSecret';
//set endpoint url. Eg. test or prod
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

$connector = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);
```

### 3. Create Order
Create a new order with the given merchant and cart, where the cart contains the order rows.
Returns the order information and the Gui needed to display the iframe Svea checkout.

[See full Create order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/create-order.php)

#### 3.1 Order data

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| MerchantSettings              |	*        | array     | List of [*Merchant settings*] (#71-merchantsettings) |
| Cart                          |	*        | array     | [*items*](#72-items) list |
| Locale                        |	*        | string    | Language Culture Name (eg. "sv-SE")|
| Currency                      |	*        | string    | Currency as ISO 4217 eg. "SEK"|
| CountryCode                   |	*        | string    | Client country code as ISO 3166 (eg. "SE") |
| ClientOrderNumber             |	*        | string    | A string with maximum of 32 chars that identifies the order in merchant's system. |
| PresetValues                  |	         | array     | List of [*Preset values*](#74-presetvalue) to be displayed when the Svea Checkout is loaded|


Sample order data
```php
// Example of required data for creating order
$data = array(
    "CountryCode" => "SE",
    "Currency" => "SEK",
    "Locale" => "sv-SE",
    "Cart" => array(
        "items" => array(
            array(
                "ArticleNumber" => "123456789",
                "Name" => "Car",
                "Quantity" => 200,
                "UnitPrice" => 12300,
                "DiscountPercent" => 1000,
                "VatPercent" => 2500
            ),
            array(
                "ArticleNumber" => "987654321",
                "Name" => "Fork",
                "Quantity" => 300,
                "UnitPrice" => 15800,
                "DiscountPercent" => 2000,
                "VatPercent" => 2500
            ),
            array(
                "Type" => "shipping_fee",
                "ArticleNumber" => "SHIPPING",
                "Name" => "Shipping fee",
                "Quantity" => 100,
                "UnitPrice" => 4900,
                "VatPercent" => 2500
            )
        )
    ),
    "MerchantSettings" => array(
        "TermsUri" => "http://localhost:51898/terms",
        "CheckoutUri" => "http://localhost:51925/",
        "ConfirmationUri" => "http://localhost:51925/checkout/confirm",
        "PushUri" => "https://svea.com/push.aspx?sid=123&svea_order=123"
    )
);
```

#### 3.2 Create the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
// require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->create($data);
```

### 4. Get Order
Get an existing order. Returns the order information and the Gui needed to display the iframe for Svea checkout.

[See full Get order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/get-order.php)

| Parameters IN                | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| OrderId                      |	*      | Long      | The id of the order received when creating the order|

#### 4.1 Get the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
// require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->get($orderId);
```

### 5. Update Order
Update an existing order. Returns the order information and the updated Gui needed to display the iframe for Svea checkout.

[See full Update order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/update-order.php)

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| OrderId                       |	*        | Long      | The id of the order recieved when creating the order|
| Cart                          |	         | array     | [*items*](#72-items) list |

Sample order data
```php
// Example of required data for creating order
$data = array(
    "Id" => 9,
    "Cart" => array(
        "Items" => array(
            array(
                "ArticleNumber" => "123456789",
                "Name" => "Dator",
                "Quantity" => 200,
                "UnitPrice" => 12300,
                "DiscountPercent" => 1000,
                "VatPercent" => 2500
            ),
            array(
                "Type" => "shipping_fee",
                "ArticleNumber" => "SHIPPING",
                "Name" => "Shipping Fee Updated",
                "Quantity" => 100,
                "UnitPrice" => 4900,
                "VatPercent" => 2500
            )
        )
    )
);
```

#### 5.1 Update the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
// require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->update($data);
```

### 6. Response
The create method will return an array with the response data. The response contains information about the Cart,
merchantSettings, Customer and the Gui for the checkout.

| Parameters OUT                | Description  |
|-------------------------------|--------------|
| MerchantSettings              | List of [*Merchant settings*] (#71-merchantsettings) |
| Cart                          | [*items*](#72-items) list |
| Customer                      | [*Customer*](#76-customer) details list |
| ShippingAddress               | [*Address*](#77-address) details list |
| BillingAddress                | [*Address*](#77-address) details list |
| Gui                           | [*Gui*](#75-gui) details list |
| Locale                        | Language Culture Name (eg. "sv-SE")|
| Currency                      | Currency as ISO 4217 eg. "SEK"|
| CountryCode                   | Client country code as ISO 3166 (eg. "SE") |
| PresetValues                  | [*PresetValue*](#74-presetvalue) details list |
| ClientOrderNumber             | A string with maximum of 32 characters identifying the order in the merchant’s system. |
| OrderId                       | The Svea order id |
| EmailAddress                  | The customer’s email address |
| PhoneNumber                   | The customer’s phone number |
| Status                        | [*CheckoutOrderStatus*](#79-checkoutorderstatus) |


Sample response
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
    [ClientOrderNumber] => '78691'
    [OrderId] => 9
    [EmailAddress] => 'integration@svea.com'
    [PhoneNumber] => '1234567'
    [Status] => Created
)
```

The checkout Gui contains the Snippet and the Layout. The Snippet contains the Html and JavaScript that you implement on your
page where you want to display the iframe for Svea checkout. The Layout is a String defining the orientation of the customers screen.

```php
echo $response['Gui']['Snippet']
```

### 7. Data structures

#### 7.1 MerchantSettings

| Parameters IN                | Required  | Type      | Description  | Limits  |
|------------------------------|-----------|-----------|--------------|---------|
| TermsUri                     |	*      | string    | URI to the page with the terms | 1-500 characters, must be a valid Url |
| CheckoutUri                  |	*      | string    | URI to the page that contains the checkout | 1-500 characters, must be a valid Url |
| ConfirmationUri              |	*      | string    | URI to the page with the confirmation information for an order. | 1-500 characters, must be a valid Url |
| PushUri                      |	*      | string    | URI for a callback to receive messages | 1-500 characters, must be a valid Url |

#### 7.2 Items

| Parameters IN                | Required  | Type                                 | Description         |
|------------------------------|-----------|--------------------------------------|---------------------|
| Items                        |	*      | Array of [*OrderRows*](#73-orderrow)  | See structure below |

#### 7.3 OrderRow

| Parameters IN                | Required   | Type      | Description  | Limits  |
|------------------------------|------------|-----------|--------------|---------|
| ArticleNumber                |	*       | string    | Articlenumber as a string, can contain all characters | Maximum 1000 characters |
| Name                         |	*       | string    | Article name | 1-40 characters |
| Quantity                     |	*       | int       | Set as basis point (1/100) e.g  2 = 200      | 1-9 digits. Minor currency |
| UnitPrice                    |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500 | 1-13 digits, can be negative. Minor currency |
| DiscountPercent              |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500 | 0-100 |
| VatPercent                   |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500 | Valid vat percentage for that country. Minor currency |
| Unit                         |            | string(3) | Unit type| 0-4 characters|

#### 7.4 PresetValue

| Parameters IN             | Required  | Type          | Description  |
|---------------------------|-----------|---------------|--------------|
| TypeName                  |	*       | string        | Name of the field you want to set (Eg. emailAddress) |
| Value                     |	*       | string        | Value to be set |
| IsReadOnly                |	*       | Boolean       | Set if the field should be editable by the customer |

**List of presetvalue typenames**

| Parameter                 | Type          | Description  | Limits       |
|---------------------------|---------------|--------------|--------------|
| NationalId                | string        |              | Company specific validation |
| EmailAddress              | string        |              | Max 50 characters, will be validated as an email address |
| PhoneNumber               | string        |              | 1-18 digits, can include “+”, “-“s and space |
| PostalCode                | string        |              | Company specific validation |
| IsCompany                 | Boolean       | Required if nationalid is set | |

#### 7.5 Gui

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| Layout                       |	*       | string    | String defining the orientation of the customers screen |
| Snippet                      |	*       | string    | Snippet with Html and JavaScript for the Iframe|

#### 7.6 Customer

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| NationalId                   |	*       | string    | Social security number or vat number |
| IsCompany                    |	*       | Boolean   | True if nationalId is a vat number |
| IsMale                       |	        | Nullable Boolean  | Indicating if the customer is male or not |
| DateOfBirth                  |	        | Nullable datetime | Required only for DE and NL or if NationalId is not set for any reason |

#### 7.7 Address

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| FullName                     |	*       | string    |              |
| FirstName                    |            | string    |              |
| LastName                     |	        | string    |              |
| StreetAddress                |	*       | string    |              |
| CoAddress                    |	        | string    |              |
| PostalCode                   |	*       | string    |              |
| City                         |	*       | string    |              |
| CountryCode                  |	*       | string    |              |

#### 7.8 Customer

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| NationalId                   |	*       | string    | Social security number or vat number |
| IsCompany                    |	*       | Boolean    | True if nationalId is a vat number |
| IsMale                       |	        | Nullable Boolean    |  |
| DateOfBirth                  |	        | Nullable datetime | |

#### 7.9 CheckoutOrderStatus

The order can only be considered “ready to send to customer” when the checkoutorderstatus is PaymentGuaranteed or Final. No other status can guarantee payment.

| Parameters OUT               | Description  |
|------------------------------|--------------|
| Cancelled                    | The order has been cancelled due to inactivity. |
| Created                      | The order has been created.  |
| Confirmed                    | The order has been confirmed using card payment and is waiting to be paid by the customer.   |
| PaymentGuaranteed            | The order has been confirmed using a credit option; invoice, paymentplan or accountcredit. |
| WaitingToBeSent              | The order is finished and is waiting to be sent to WebPay’s subsystems for further handling. |
| Final                        | The order is completed in the checkout and managed by WebPay’s subsystems.|

#### 8. SubSystemInfo

Get an existing order sub-system information.
Returns information needed to identify an order in any of WebPay’s subsystems.

| Parameters IN                | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| OrderId                      |	*      | Long      | Checkoutorderid of the specified order |


| Parameters OUT    | Type | Description  |
|-------------------|------|--------------|
| ClientId          | Long | Used to identify the client in WebPay’s subsystems |
| SveaOrderId       | Long | Used to identify the order in WebPay’s subsystems |
| TransactionId     | Long | Used to Identify the transaction in WebPay’s paymentgateway-subsystem |
| PaymentType       | Long | The paymenttype of the order |

#### 8.1 Get the Order SubSystem Info
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
// require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->getOrderSubsystemInfo($orderId);
```
