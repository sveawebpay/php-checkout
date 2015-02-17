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

//      Array
//(
//    [url] => http://sveawebpaycheckoutws.dev.svea.com/checkout/orders
//    [content_type] => application/json; charset=utf-8
//    [http_code] => 500
//    [header_size] => 325
//    [request_size] => 716
//    [filetime] => -1
//    [ssl_verify_result] => 0
//    [redirect_count] => 0
//    [total_time] => 0.062
//    [namelookup_time] => 0
//    [connect_time] => 0
//    [pretransfer_time] => 0
//    [size_upload] => 575
//    [size_download] => 7377
//    [speed_download] => 118983
//    [speed_upload] => 9274
//    [download_content_length] => 7377
//    [upload_content_length] => 575
//    [starttransfer_time] => 0.062
//    [redirect_time] => 0
//    [certinfo] => Array
//        (
//        )
//
//    [primary_ip] => 10.111.50.100
//    [primary_port] => 80
//    [local_ip] => 127.0.0.1
//    [local_port] => 60983
//    [redirect_url] =>
//)
        $this->assertEquals($curl_info['http_code'],201);//Statuscode 201 means success
    }

    function test_get_orderid_from_http_header_response() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        $orderUrl = SveaConnector::getOrderUrl();
        print_r($orderUrl);
         $this->assertEquals('1',201);
    }

    function test_get_order() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        $order->get();
    }
}