# PHP Connection library for Svea Checkout
Version 1.0.0

## Index
* [1. Setup](#1-setup)
* [2. Create a Connector](#2-create-a-connector)
* [3. Create order](#3-create-order)
* [4. Get order](#4-get-order)
* [5. Update order](#5-update-order)
* [6. Response](#6-response)
* [7. Data structures](#7-data-structures)

[<< To top](# PHP Integration Package API for Svea Checkout)

The  Connection library for Svea Checkout offers an easy integration with the Svea Checkout Api, and is the easiest way to integrate the
Svea Checkout into you website.
The library provides entrypoints to Create Order, Get Order and for Updating Order.

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

#### 1.2 Ftp
Upload the src folder to you project server. Include the autoload.php file into your integration file.

### 2 Create a Connector
You use a connector object as parameter when creating a CheckoutClient request.
Parmeters for creating Connector are: merchantId, sharedSecret and base Api url.
```php
// inlude the library
include 'vendor/autoload.php'

// or include class
use \Svea\Checkout\Transport\Connector;

$merchantId = '1';
$sharedSecret = 'sharedSecret';
//set endpoint url. Eg. test or prod
$baseUrl = \Svea\Checkout\Transport\Connector::TEST_BASE_URL;

$connector = \Svea\Checkout\Transport\Connector::init($merchantId, $sharedSecret, $baseUrl);
```

### 3. Create Order
Creates a new order with the given merchant and cart, where the cart contains the orderrows.
Returns the order information and the Gui needed to display the Iframed Svea checkout.

[See full Create order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/create-order.php)

#### 3.1 Order data

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| merchantSettings              |	*        | array     | List of [*Merchant settings*] (#71-merchantsettings) |
| cart                          |	*        | array     | [*items*](#72-items) list |
| locale                        |	*        | string    | Language Culture Name (eg. "sv-SE")|
| currency                      |	*        | string    | Currency as ISO 4217 eg. "SEK"|
| countrycode                   |	*        | string    | Client country code as ISO 3166 (eg. "SE") |
| presetValues                  |	        | array    | List of [*Preset values*](#74-presetvalue) to be displayed when the Svea Checkout is loaded|


Sample order data
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
```

#### 3.2 Create the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point for creating, getting and updating the order.

```php
// inlude the library
include 'vendor/autoload.php'

// or include class
use \Svea\Checkout\Implementation\CheckoutClient;

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

//call the method *create*
$response = $checkoutClient->create($data);
```

### 4. Get Order <a id="get-order"></a>
Get an existing order. Returns the order information and the Gui needed to display the Iframed Svea checkout.

[See full Get order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/get-order.php)

| Parameters IN                | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| orderId                      |	*      | Long    | The id of the order recieved when creating the order|

#### 4.1 Get the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point for creating, getting and updating the order.

```php
// inlude the library
include 'vendor/autoload.php'

// or include class
use \Svea\Checkout\Implementation\CheckoutClient;

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

//call the method *create*
$response = $checkoutClient->get($orderId);
```

### 5. Update Order <a id="update-order"></a>
Update an existing order. Returns the order information and the updated Gui needed to display the Iframed Svea checkout.

[See full Update order example](https://github.com/sveawebpay/php-checkout-dev/blob/master/examples/update-order.php)

| Parameters IN                 | Required   | Type      | Description  |
|-------------------------------|------------|-----------|--------------|
| orderId                       |	*      | Long    | The id of the order recieved when creating the order|
| cart                          |	        | array     | [*items*](#72-items) list |

Sample order data
```php
// - Add required information for creating order
$data = array(
    "id" => 9,
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
                "type" => "shipping_fee",
                "articlenumber" => "SHIPPING",
                "name" => "Shipping Fee Updated",
                "quantity" => 100,
                "unitprice" => 4900,
                "vatpercent" => 2500
            )
        )
    )
);
```

#### 5.1 Update the Order
Create a CheckoutClient object with the [*Connector*](#3-create-a-connector) as parameter.
The checkoutClient object is an entry point for creating, getting and updating the order.

```php
// inlude the library
include 'vendor/autoload.php'

// or include class
use \Svea\Checkout\Implementation\CheckoutClient;

$checkoutClient = new \Svea\Checkout\CheckoutClient($connector);

//call the method *create*
$response = $checkoutClient->update($data);
```

### 6. Response
The create method will return an array with the response data. The response contains information about the Cart,
merchantSettnings, Customer and the Gui for the checkout.

| Parameters OUT                | Description  |
|-------------------------------|--------------|
| MerchantSettings              | List of [*Merchant settings*] (#41-merchantsettings) |
| Cart                          | [*items*](#41-items) list |
| Customer                      | [*Customer*](#76-customer) details list |
| ShippingAddress               | [*Address*](#77-address) details list |
| BillingAddress                | [*Address*](#77-address) details list |
| Gui                           | [*Gui*](#75-gui) details list |
| Locale                        | Language Culture Name (eg. "sv-SE")|
| Currency                      | Currency as ISO 4217 eg. "SEK"|
| Countrycode                   | Client country code as ISO 3166 (eg. "SE") |
| PresetValues                  | [*PresetValue*](#74-presetvalue) details list |
| OrderId                       | The Svea order id |
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
    [OrderId] => 9
    [Status] => Created
)
```

The checkout Gui contains the Snippet and the Layout. The Snippet contains the Html and JavaScript that you implement on your
page where you want to display the Iframed checkuot. The Layout is a String defining the orientation of the customers screen.

```php
echo $response['Gui']['Snippet']
```

### 7. Data structures

#### 7.1 MerchantSettings

| Parameters                   | Required  | Type      | Description  |
|------------------------------|-----------|-----------|--------------|
| termsuri                     |	*      | string    | URI to the page with the terms |
| checkouturi                  |	*      | string    | URI to the page that contains the checkout |
| confirmationuri              |	*      | string    | URI to the page with the confirmation information for an order. |
| pushuri                      |	*      | string    | URI for a callback to recieve messages |

#### 7.2 Items

Array of [*OrderRows*](#73-orderrow)

#### 7.3 OrderRow

| Parameters                   | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| articlenumber                |	*       | string    | Articlenumber as a string, can contain all characters |
| name                         |	*       | string    | |
| quantity                     |	*       | int       |  |
| unitprice                    |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500|
| discountpercent              |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500 |
| vatpercent                   |	*       | int       | Set as basis point (1/100) e.g. 25.00 = 2500 |
| unit                         |                | string(3) |  Unit type|

#### 7.4 PresetValue

| Parameters                | Required   | Type      | Description  |
|---------------------------|------------|-----------|--------------|
| typename                  |	*       | string        | Name of the field you want to set (Eg. emailaddress) |
| value                     |	*       | string        | Value to be set |
| isreadonly                |	*       | Boolean       | Set if the field should be editable by the customer |

#### 7.5 Gui

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| layout                       |	*       | string    | String defining the orientation of the customers screen |
| snippet                      |	*       | string    | Snippet with Html and JavaScript for the Iframe|

#### 7.6 Customer

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| nationalid                   |	*       | string    | Social security number or vat number |
| iscompany                    |	*       | Boolean    | True if nationalid is a vat number |
| ismale                       |	       | Nullable Boolean    |  |
| dateofbirth                  |	       | Nullable datetime | |

#### 7.7 Address

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| emailaddress                   |	*       | string    |  |
| phonenumber                    |              | string    | True if nationalid is a vat number |
| fullname                       |	*       |string|  |
| firstname                      |              | string | |
| lastname                       |	       | string | |
| streetaddress                 |	*      | string| |
| coaddress                     |	       | string| |
| housenumber                   |	       | string | NL, DE only|
| zipcode                       |	 *      | string | |
| city                          |	 *      | string | |
| countrycode                   |	 *      | string | |

#### 7.8 Customer

| Parameters OUT               | Required   | Type      | Description  |
|------------------------------|------------|-----------|--------------|
| nationalid                   |	*       | string    | Social security number or vat number |
| iscompany                    |	*       | Boolean    | True if nationalid is a vat number |
| ismale                       |	       | Nullable Boolean    |  |
| dateofbirth                  |	       | Nullable datetime | |

#### 7.9 CheckoutOrderStatus

| Parameters OUT               | Description  |
|------------------------------|--------------|
| created                       | The order has been created and can be changed |
| confirmed                     | The customer has chose adress and pushed "Complete purchase", the orderrows can no longer be changed. |
| submitted                     | The order is submitted to our internal system. The customer can change payment type during a time window.  |
| pendingacknowledge            | The order has been pushed to the merchant and is awaiting an acknowledgement. The order is locked and the method of payment can not be changed by the customer.|
| complete                      | A response has been given to confirm that the order has been taken care of by an other system. The order is now fully completed in the checkout system. |

