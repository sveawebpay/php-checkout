<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class SveaCheckoutOrderUnitTest extends PHPUnit_Framework_TestCase {

    function test_get_order_object() {
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $this->assertEquals(get_class($order),'SveaCheckoutOrder');
    }

    private function get_request_data_array() {
        $data["merchant"] = array(
            "id" => 24,
            "termsuri" => "http://svea.com/terms.aspx",
            "checkouturi" => "https://svea.com/checkout.aspx",
            "confirmationuri" => "https://svea.com/thankyou.aspx?sid=123&svea_order={checkout.order.uri}",
            "pushuri" => "https://svea.com/push.aspx?sid=123&svea_order={checkout.order.uri}"
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

        return $data;
    }

    function test_create() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $curl_info = $order->create($data);
        print_r($curl_info);
//        headers are now transformed to a readable array
//        Array
//        (
//            [Cache-Control] => no-cache
//            [Pragma] => no-cache
//            [Content-Length] => 0
//            [Expires] => -1
//            [Location] => http://sveawebpaycheckoutws.dev.svea.com/checkout/orders/48
//            [Server] => Microsoft-IIS/8.5
//            [X-AspNet-Version] => 4.0.30319
//            [X-Powered-By] => ASP.NET
//            [Date] => Fri, 13 Feb 2015 12:41:31 GMT
//        )
        $this->assertEquals($curl_info['http_code'],201);//Statuscode 201 means success
    }

    function test_get_orderid_from_http_header_response() {

    }

//    function test_fetch() {
//        $data = $this->get_request_data_array();
//         $connector = SveaConnector::create();
//        $order = new SveaCheckoutOrder($connector);
//        $order->create($data);
//        $order->get();
//    }
}