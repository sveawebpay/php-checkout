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
* [8. HttpStatusCodes](#8-httpstatuscodes)


## Introduction
The checkout offers a complete solution with a variety of payment methods. The underlying systems for the checkout is our
paymentPlan, invoice, account payments. Also including our own payment gateway with PCI level 1 for card payments. 
The checkout supports both B2C and B2B payments, fast customer identification and caches customers behaviour. 
For administration of orders, you can either implement it in your own project, or use our new admin interface.

The library provides entry points to Create Order, Get Order and for Updating Order.

### 1. Setup

The checkout requires jQuery to be able to run properly, if jQuery isn't loaded the iFrame won't appear.

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

### 2. Create a Connector
You use a connector object as parameter when creating a CheckoutClient request.
Parameters for creating Connector are: merchantId, sharedSecret and base Api url.

```php
// include the library
include 'vendor/autoload.php';

// without composer
require_once 'include.php';

$checkoutMerchantId = '100001';
$checkoutSecret = 'checkoutSecret';
//set endpoint url. Eg. test or prod
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

$connector = \Svea\Checkout\Transport\Connector::init($checkoutMerchantId, $checkoutSecret, $baseUrl);
```

### 3. Create Order
Create a new order with the given merchant and cart, where the cart contains the order rows.
Returns the order information and the Gui needed to display the iframe Svea checkout.

[See full Create order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/create-order.php)

#### 3.1 Order data

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| MerchantSettings              |	*        | MerchantSettings     | Specific merchant URIs, see [*Merchant settings*](#71-merchantsettings) |
| Cart                          |	*        | Cart     | A cart-object containing the [*OrderRows*](#73-orderrows) |
| Locale                        |	*        | string    | The current locale of the checkout, i.e. sv-SE etc. |
| Currency                      |	*        | string    | Currency as ISO 4217 eg. "SEK" |
| CountryCode                   |	*        | string    | The current currency as defined by ISO 4217, i.e. SEK, NOK etc. |
| ClientOrderNumber             |	*        | string    | A string with maximum of 32 chars that identifies the order in merchant's system. |
| PresetValues                  |	         | List of PresetValue     | [*Preset values*](#74-presetvalue) chosen by the merchant to be prefilled and eventually locked for changing by the customer. |


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
Create a CheckoutClient object with the [*Connector*](#2-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->create($data);
```

### 4. Get Order
Get an existing order. Returns the order information and the Gui needed to display the iframe for Svea checkout.

[See full Get order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/get-order.php)

| Parameters IN                | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| Id                           |	*      | Long      | Checkoutorderid of the specified order. |

| Parameters OUT               | Type      | Description  |
|------------------------------|-----------|--------------|
| Data                         | Data      | An object containing all information needed to return a checkout to the merchant, see (#6-response) |

#### 4.1 Get the Order
Create a CheckoutClient object with the [*Connector*](#2-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->get($orderId);
```

### 5. Update Order
Update an existing order. Returns the order information and the updated Gui needed to display the iframe for Svea checkout.

[See full Update order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/update-order.php)

| Parameters IN  as URI-parameters: | Required   | Type      | Description  |
|-----------------------------------|------------|-----------|--------------|
| Id                                |	*        | Long      | Checkoutorderid of the specified order. |

| Parameters IN as Content:     | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| Cart                          |	         | Cart      | A cart-object containing the [*OrderRows*](#73-orderrow) |

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
Create a CheckoutClient object with the [*Connector*](#2-create-a-connector) as parameter.
The checkoutClient object is an entry point to use library.

```php
// include the library
include 'vendor/autoload.php'

// without composer
require_once 'include.php';

...

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

$response = $checkoutClient->update($data);
```

### 6. Response
The create method will return an array with the response data. The response contains information about the Cart,
merchantSettings, Customer and the Gui for the checkout.

| Parameters OUT                | Type                 | Description |
|-------------------------------|----------------------|-------------|
| MerchantSettings              | MerchantSettings     | Specific merchant URIs, see [*Merchant settings*](#71-merchantsettings) |
| Cart                          | Cart                 | A cart-object containing the [*OrderRows*](#73-orderrow) |
| Gui                           | Gui                  | See [*Gui*](#75-gui) |
| Customer                      | Customer             | Identified [*Customer*](#76-customer) of the order. |
| ShippingAddress               | Address              | Shipping [*Address*](#77-address) of identified customer. |
| BillingAddress                | Address              | Billing [*Address*](#77-address) of identified customer. |
| Locale                        | String               | The current locale of the checkout, i.e. sv-SE etc. |
| Currency                      | String               | The current currency as defined by ISO 4217, i.e. SEK, NOK etc. |
| CountryCode                   | String               | Defined by two-letter ISO 3166-1 alpha-2, i.e. SE, DE, FI etc.  |
| ClientOrderNumber             | String               | A string with maximum of 32 characters that identifies the order in the merchant’s systems |
| PresetValues                  | List of PresetValues | [*Preset values*](#74-presetvalue) chosen by the merchant to be prefilled and eventually locked for changing by the customer. |
| OrderId                       | Long                 | Checkoutorderid of the order. |
| Status                        | The current state of the order, see [*CheckoutOrderStatus*](#78-checkoutorderstatus) below. |
| EmailAddress                  | String               | The customer’s email address |
| PhoneNumber                   | String               | The customer’s phone number |


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
| TermsUri                     |	*      | string    | URI to a page with webshop specific terms. | 1-500 characters, must be a valid Url |
| CheckoutUri                  |	*      | string    | URI to the page in the webshop that loads the Checkout.  | 1-500 characters, must be a valid Url |
| ConfirmationUri              |	*      | string    | URI to the page in the webshop displaying specific information to a customer after the order has been confirmed. | 1-500 characters, must be a valid Url |
| PushUri                      |	*      | string    | URl to a location that is expecting callbacks from the Checkout when an order is confirmed. Uri must have the {checkout.order.uri} placeholder.  | 1-500 characters, must be a valid Url |

#### 7.2 Items

| Parameters IN                | Required  | Type                                 | Description         |
|------------------------------|-----------|--------------------------------------|---------------------|
| Items                        |	*      | List of [*OrderRows*](#73-orderrow)  | See structure below |

#### 7.3 OrderRow

| Parameters IN                | Required   | Type      | Description  | Limits  |
|------------------------------|------------|-----------|--------------|---------|
| ArticleNumber                |	        | String    | Articlenumber as a string, can contain letters and numbers. | Maximum 1000 characters |
| Name                         |	*       | String    | Article name | 1-40 characters |
| Quantity                     |	*       | Integer       | Set as basis point (1/100) e.g  2 = 200      | 1-9 digits. Minor currency |
| UnitPrice                    |	*       | Integer       | Set as basis point (1/100) e.g. 25.00 = 2500 | 1-13 digits, can be negative. Minor currency |
| DiscountPercent              |	        | Integer       | The discountpercent of the product. | 0-100 |
| VatPercent                   |	*       | Integer       | The VAT percentage of the current product. | Valid vat percentage for that country. Minor currency.  |
| Unit                         |            | String        | The unit type, e.g., “st”, “pc”, “kg” etc. | 0-4 characters|

#### 7.4 PresetValue

| Parameters IN             | Required  | Type          | Description  |
|---------------------------|-----------|---------------|--------------|
| TypeName                  |	*       | String        | Name of the field you want to set (see list below).  |
| Value                     |	*       | String        | See limits below. |
| IsReadOnly                |	*       | Boolean       | Should the preset value be locked for editing, set readonly to true. Usable if you only let your registered users use the checkout. |

**List of presetvalue typenames**

| Parameter                 | Type          | Description  | Limits       |
|---------------------------|---------------|--------------|--------------|
| NationalId                | String        |              | Company specific validation |
| EmailAddress              | String        |              | Max 50 characters, will be validated as an email address |
| PhoneNumber               | String        |              | 1-18 digits, can include “+”, “-“s and space |
| PostalCode                | String        |              | Company specific validation |
| IsCompany                 | Boolean       | Required if nationalid is set | |

#### 7.5 Gui

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| Layout                       |	*       | String    | Defines the orientation of the device, either “desktop” or “portrait”.  |
| Snippet                      |	*       | String    | HTML-snippet including javascript to populate the iFrame. |

#### 7.6 Customer

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| NationalId                   |	*       | String    | Personal- or organizationnumber. |
| IsCompany                    |	*       | Boolean   | True if nationalid is organisationnumber, false if nationalid is personalnumber.   |
| IsMale                       |	        | Boolean  | Indicating if the customer is male or not. |
| DateOfBirth                  |	        | Nullable datetime | Required only for DE and NL or if NationalId is not set for any reason. |

#### 7.7 Address

| Parameters OUT               | Type      | Description  |
|------------------------------|-----------|--------------|
| FullName                     | String    | Company: name of the company. Individfual: first name(s), middle name(s) and last name(s). |
| FirstName                    | String    | First name(s).  |
| LastName                     | String    | Last name(s).   |
| StreetAddress                | String    | Street address.  |
| CoAddress                    | String    | Co address.  |
| PostalCode                   | String    | Postal code.  |
| City                         | String    | City.  |
| CountryCode                  | String    | Defined by two-letter ISO 3166-1 alpha-2, i.e. SE, DE, FI etc.|

#### 7.8 CheckoutOrderStatus

The order can only be considered “ready to send to customer” when the checkoutorderstatus is Final. No other status can guarantee payment.

| Parameters OUT               | Description  |
|------------------------------|--------------|
| Cancelled                    | The order has been cancelled due to inactivity. |
| Created                      | The order has been created.  |
| Confirmed                    | The order has been confirmed using card payment and is waiting to be paid by the customer.   |
| PaymentGuaranteed            | The order has been confirmed using a credit option; invoice, paymentplan or accountcredit. |
| WaitingToBeSent              | The order is finished and is waiting to be sent to WebPay’s subsystems for further handling. |
| Final                        | The order is completed in the checkout and managed by WebPay’s subsystems.|

#### 7.9 Locale
| Parameter | Description     |
|-----------|-----------------|
| sv-SE     | Swedish locale. |
| en-US     | English locale. |

### 8.0 HttpStatusCodes
| Parameter | Type         | Description |
|-----------|--------------|-------------|
| 200       | Success      | Request was successful. |
| 201       | Created      | The order was created successfully. |
| 302       | Found        | The order was found. |
| 400       | Bad Request  | The input data was invalid. |
| 401       | Unauthorized | The request did not contain correct authorization. |
| 403       | Forbidden    | The request did not contain correct authorization. |
| 404       | Not found    | No order with the requested ID was found. |
