# PHP Integration Package API for Svea Checkout
Version 1.0.0

## Index
* [1. Introduction](https://github.com/sveawebpay/dotnet-integration/tree/master#1-introduction)
* [2. Build and Configuration](https://github.com/sveawebpay/dotnet-integration/tree/master#2-build-and-configuration)
* [3. Create order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-create-order)
* [3. Get order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-get-order)
* [3. Update order](https://github.com/sveawebpay/dotnet-integration/tree/master#3-update-order)

[<< To top](https://github.com/sveawebpay/dotnet-integration/tree/master#cnet-integration-package-api-for-svea-checkout)

### 1. Create order
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

