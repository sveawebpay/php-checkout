<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCheckoutConnector {

    private $curlHandler;

    public function __construct($curlHandler) {
        $this->curlHandler = $curlHandler;
    }

    public function apply($method, $resource, $data = NULL) {
        print_r(gettype($resource));
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
//             print_r(gettype($this->handler));
            $json = json_encode($data);
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $json);
            curl_setopt($this->handler, CURLOPT_POST, true);
            curl_setopt($this->handler, CURLOPT_URL, $this->svea_connection_url);
        } elseif ($method == 'GET') {
//            print_r(gettype($this->handler));
             curl_setopt($this->handler, CURLOPT_URL, $data);
        }
        curl_setopt($this->handler,CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
        curl_setopt($this->handler, CURLOPT_HEADER, true);//to get headers in response


        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);//set to get response

        //process the headers to readable format. TODO: Need it?
        $curlHeaders = new FormatHttpResponse();
        curl_setopt($this->handler, CURLOPT_HEADERFUNCTION,  array(&$curlHeaders, 'processHeader'));

        $response = $this->execute();
        $info = $this->getInfo();
        $error = $this->getError();
        $this->close();

        if ($response === false || $info === false) {
            throw new Exception(
            "Connection to '{$this->svea_connection_url}' failed: {$error}"
            );
        }

        $this->orderUrl = $curlHeaders->getHeaderValue('Location');
        return $info;
    }

}