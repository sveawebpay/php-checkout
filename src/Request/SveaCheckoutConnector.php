<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCheckoutConnector {

    private $handler;
    public $svea_connection_url = 'http://sveawebpaycheckoutws.dev.svea.com/checkout/orders';

    public function __construct() {
//        $this->handler = $curlHandler;
//         $this->handler = new SveaCurlHandler();
    }

    public function apply($method, $resource, $data = NULL) {
         $this->handler = new SveaCurlHandler();

                // Set HTTP Headers wich ones to set?
//        $request->setHeader('User-Agent', (string)$this->userAgent());
//        $request->setHeader('Authorization', "Svea {$digest}");
//        $request->setHeader('Accept', $resource->getContentType());
//        if (strlen($payload) > 0) {
//            $request->setHeader('Content-Type', $resource->getContentType());
//            $request->setData($payload);
//        }
        //create
        $curl = $this->handler->getResource();

        if ($method == 'POST') {
            $json = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_URL, $this->svea_connection_url);
        } elseif ($method == 'GET') {
             curl_setopt($curl, CURLOPT_URL, $data);
        }
        curl_setopt($curl,CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
//        curl_setopt($curl, CURLOPT_HEADER, true);//to get headers in response. Messes with the json message. Not needed?


        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//set to get response

        //process the headers to readable format. TODO: Need it?
        $curlResponse = new FormatHttpResponse();
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,  array(&$curlResponse, 'processHeader'));

        $response = $this->handler->execute();
        $info = $this->handler->getInfo();
        $error = $this->handler->getError();
        $this->handler->close();
        //TODO: don't have the if here
        if($method == 'GET') {
//               print_r($response);
//             $res = file_get_contents($response);
//                 $json = json_decode($response);
//                print_r($json);
        }


        if ($response === false || $info === false) {
            throw new Exception(
            "Connection to '{$this->svea_connection_url}' failed: {$error}"
            );
        }

//        $this->orderUrl = $curlHeaders->getHeaderValue('Location');
//        $this->handler->setLocation($curlHeaders->getHeaderValue('Location'));
        $resource->setLocation($curlResponse->getHeaderValue('Location'));
//        $result = $curlResponse->handleResponse(  $this->handler, intval($info['http_code']), strval($response));
        $result = $curlResponse->handleResponse(  $resource, intval($info['http_code']), strval($response));
//        print_r($result);
//        print_r($location);
        return $result;
    }

}