<?php

require_once 'vendor/autoload.php';


$conn = \Svea\Checkout\Transport\Connector::create(
    'merchant123',
    'SomeSecretWord',
    \Svea\Checkout\Transport\ConnectorInterface::TEST_BASE_URL
);

$data = [
    "purchase_country" => "gb",
    "purchase_currency" => "gbp",
    "locale" => "en-gb",
    "order_amount" => 10000,
    "order_tax_amount" => 2000,
    "order_lines" => [
        [
            "type" => "physical",
            "reference" => "123050",
            "name" => "Tomatoes",
            "quantity" => 10,
            "quantity_unit" => "kg",
            "unit_price" => 600,
            "tax_rate" => 2500,
            "total_amount" => 6000,
            "total_tax_amount" => 1200
        ],
        [
            "type" => "physical",
            "reference" => "543670",
            "name" => "Bananas",
            "quantity" => 1,
            "quantity_unit" => "bag",
            "unit_price" => 5000,
            "tax_rate" => 2500,
            "total_amount" => 4000,
            "total_discount_amount" => 1000,
            "total_tax_amount" => 800
        ]
    ],
    "merchant_urls" => [
        "terms" => "http://www.merchant.com/toc",
        "checkout" => "http://www.merchant.com/checkout?klarna_order_id={checkout.order.id}",
        "confirmation" => "http://www.merchant.com/thank-you?klarna_order_id={checkout.order.id}",
        "push" => "http://www.merchant.com/create_order?klarna_order_id={checkout.order.id}"
    ]
];

$cc = new \Svea\Checkout\CheckoutClient($conn);

$cc->create($data);

response:
{
    info: "".
    error: "",
    cart: [],
    errors:[
        "error1",
        "error2"
    ],
}

