<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCheckoutConnector {

    private $handler;
    public $svea_connection_url = 'http://sveawebpaycheckoutws.dev.svea.com/checkout/orders';

    public function __construct($curlHandler) {
        $this->handler = $curlHandler;
    }

    public function apply($method, $resource, $data = NULL) {
//        print_r(gettype($resource));
//        $this->handler = $resource;
                // Set HTTP Headers wich ones to set?
//        $request->setHeader('User-Agent', (string)$this->userAgent());
//        $request->setHeader('Authorization', "Svea {$digest}");
//        $request->setHeader('Accept', $resource->getContentType());
//        if (strlen($payload) > 0) {
//            $request->setHeader('Content-Type', $resource->getContentType());
//            $request->setData($payload);
//        }
        //create
        if ($method == 'POST') {
            $json = json_encode($data);
            curl_setopt($this->handler->getResource(), CURLOPT_POSTFIELDS, $json);
            curl_setopt($this->handler->getResource(), CURLOPT_POST, true);
            curl_setopt($this->handler->getResource(), CURLOPT_URL, $this->svea_connection_url);
        } elseif ($method == 'GET') {
            $this->handler = new SveaCurlHandler();//TODO: how to handle if hanler exists or not?
//            print_r(gettype($this->handler->getResource()));
             curl_setopt($this->handler->getResource(), CURLOPT_URL, $data);
        }
        curl_setopt($this->handler->getResource(),CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
        curl_setopt($this->handler->getResource(), CURLOPT_HEADER, true);//to get headers in response


        curl_setopt($this->handler->getResource(), CURLOPT_RETURNTRANSFER, true);//set to get response

        //process the headers to readable format. TODO: Need it?
        $curlHeaders = new FormatHttpResponse();
        curl_setopt($this->handler->getResource(), CURLOPT_HEADERFUNCTION,  array(&$curlHeaders, 'processHeader'));

        $response = $this->handler->execute();
        $info = $this->handler->getInfo();
        $error = $this->handler->getError();
        $this->handler->close();
        if($method == 'GET')
            print_r($response);

        if ($response === false || $info === false) {
            throw new Exception(
            "Connection to '{$this->svea_connection_url}' failed: {$error}"
            );
        }

//        $this->orderUrl = $curlHeaders->getHeaderValue('Location');
//        $this->handler->setLocation($curlHeaders->getHeaderValue('Location'));
        $resource->setLocation($curlHeaders->getHeaderValue('Location'));
//        print_r($location);
        return $info;
    }

}