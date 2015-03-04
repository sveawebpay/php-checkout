<?php

$root = realpath(dirname(__FILE__));
require_once $root . '/../src/Includes.php';

class SveaCheckoutOrderUnitTest extends PHPUnit_Framework_TestCase {

    private function get_request_data_array() {

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
         $data["MerchantSettings"] = array(
            "termsuri" => "http://svea.com/terms.aspx",
            "checkouturi" => "https://svea.com/checkout.aspx",
            "confirmationuri" => "https://svea.com/thankyou.aspx?sid=123&svea_order={checkout.order.uri}",
            "pushuri" => "https://svea.com/push.aspx?sid=123&svea_order={checkout.order.uri}"
        );
        $data["cart"] = $cart;
        $data["Locale"] = 'Sv';
        $data["MerchantId"] = 1;

        return $data;
    }

     function test_get_order_object() {
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $this->assertEquals(get_class($order),'SveaCheckoutOrder');
    }

    function test_create() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $curl_info = $order->create($data);

        $this->assertEquals(201, $curl_info->getStatus());//Statuscode 201 means order recieved
    }

    function test_get_orderid_from_http_header_response() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        $orderUrl = $order->getOrderUrl();
        $http = strpos($orderUrl, 'http://');//is http
        $service = strpos($orderUrl, 'sveawebpaycheckoutws.dev.svea.com/checkout/orders');

         $this->assertEquals(0,$http);
         $this->assertEquals(7,$service);//what comes after http://
    }

    function test_get_order() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        $curl_info = $order->get();
        $snippet_exists = sizeof($order['Gui']['Snippet']) > 0 ? TRUE : FALSE;

        $this->assertEquals(200, $curl_info->getStatus());//Statuscode 200 means success
        $this->assertTrue($snippet_exists);//Statuscode 200 means success
    }

}