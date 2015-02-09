<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class SveaCheckoutOrderUnitTest extends PHPUnit_Framework_TestCase {

    function test_get_order_object() {
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $this->assertEquals(get_class($order),'SveaCheckoutOrder');
    }

    function test_send_order_json() {
        $data["merchant"] = array(
            "id" => 24,
            "termsuri" => "http://svea.com/terms.aspx",
            "checkouturi" => "https://svea.com/checkout.aspx",
            "confirmationuri" => "https://svea.com/thankyou.aspx?sid=123&svea_order={checkout.order.uri}",
            "pushiri" => "https://svea.com/push.aspx?sid=123&svea_order={checkout.order.uri}"
        );
        $cart["items"] = array(
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
                "name" => "Shipping Fee",
                "quantity" => 100,
                "unitprice" => 4900,
                "discountpercent" => 1000,
                "vatpercent" => 2500
        )
        );
        $data["cart"] = $cart;

        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);

         $this->assertEquals('1','SveaCheckoutOrder');
    }
}