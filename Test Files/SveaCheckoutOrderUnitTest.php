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
        $data["Locale"] = 'sv-SE';
        $data["MerchantId"] = 1;

        return $data;
    }

    function helper_create($connector = NULL) {
        $data = $this->get_request_data_array();
        if(!$connector)
            $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        return $order;
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
        $service = strpos($orderUrl, 'sveawebpaycheckoutws.test.svea.com/checkout/orders');

         $this->assertEquals(0,$http);
         $this->assertEquals(7,$service);//what comes after http://
    }

    function test_get_order() {
        $data = $this->get_request_data_array();
        $connector = SveaConnector::create();
        $order = new SveaCheckoutOrder($connector);
        $order->create($data);
        $curl_info = $order->get();
//        print_r($order);
        $snippet_exists = sizeof($order['Gui']['Snippet']) > 0 ? TRUE : FALSE;

        $this->assertEquals(200, $curl_info->getStatus());//Statuscode 200 means success
        $this->assertTrue($snippet_exists);//Statuscode 200 means success
    }

    function test_update_cart() {
        $cart["items"] = array(
            array(
                "articlenumber" => "123456789",
                "name" => "Dator",
                "quantity" => 2,//quantity changed
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
        //create an order
        $connector = SveaConnector::create();
        $order = $this->helper_create($connector);
        $orderUrl = $order->getOrderUrl();
        //orderUrl har sparats i session
        //create a new order object by its orderUrl
        $orderupdate = new SveaCheckoutOrder($connector, $orderUrl);
//        $order->get();
        $data['cart'] = $cart;
        $curl_info = $orderupdate->update($data,$orderUrl);

         $this->assertEquals(201, $curl_info->getStatus());//Statuscode 201 means created

    }
    function test_cart_gets_updated() {
        $cart["items"] = array(
            array(
                "articlenumber" => "123456789",
                "name" => "Dator",
                "quantity" => 2,//quantity changed
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
        //create an order
        $connector = SveaConnector::create();
        $order = $this->helper_create($connector);
        $orderUrl = $order->getOrderUrl();
        //orderUrl har sparats i session
        //create a new order object by its orderUrl
        $orderupdate = new SveaCheckoutOrder($connector, $orderUrl);
//        $order->get();
        $data['cart'] = $cart;
        $orderupdate->update($data,$orderUrl);
        $orderupdate->get();
        
        $this->assertEquals(2, $orderupdate['Cart']['Items'][0]['Quantity']);//Check quantity was changed

    }

}