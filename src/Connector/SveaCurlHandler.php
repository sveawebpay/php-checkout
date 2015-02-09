<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

class SveaCurlHandler {

    /**
     * cUrl handler
     * @var resource
     */
    private $handler = null;

    /**
     * Do curl_init and create a new curl handler
     * @return curl handler
     */
    public function __construct() {
        $this->handler = curl_init();
        return $this->handler;
    }
    /**
     * Do curl_exec
     * @return mixed response
     */
    public function execute() {
        return curl_exec($this->handler);
    }
    /**
     * Do curl_close
     * void
     */
    public function close() {
        curl_close($this->handler);
    }

    public function getError() {
         return curl_error($this->handler);
    }

    public function getInfo() {
        return curl_getinfo($this->handler);
    }

        public function apply($method, $data) {
        if ($method == 'POST') {
            $json = json_encode($data);
            curl_setopt($this->handler, CURLOPT_HEADER, true);//to get headers in response
            curl_setopt($this->handler, CURLOPT_URL, 'http://sveawebpaycheckoutws.dev.svea.com/checkout/orders/');
            curl_setopt( $this->handler, CURLOPT_POST, true);
            curl_setopt( $this->handler, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($this->ch,CURLOPT_URL , $this->curl_url);
            curl_setopt( $this->handler, CURLOPT_POSTFIELDS, $json);
            //force curl to trust https
//            curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, 2);
//            curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, true);
            $result =  $this->execute();
            $error =  $this->getError();
            $info = $this->getInfo();
//            print_r($result);
            print_r(' ------- ');
            print_r($result);
             // Set HTTP Headers wich ones to set?
//        $request->setHeader('User-Agent', (string)$this->userAgent());
//        $request->setHeader('Authorization', "Klarna {$digest}");
//        $request->setHeader('Accept', $resource->getContentType());
//        if (strlen($payload) > 0) {
//            $request->setHeader('Content-Type', $resource->getContentType());
//            $request->setData($payload);
//        }
        }
    }
}