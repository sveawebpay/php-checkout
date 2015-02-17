<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

/**
 * Handle curl commands
 */
class SveaCurlHandler {

    private $orderUrl;

    public $svea_connection_url = 'http://sveawebpaycheckoutws.dev.svea.com/checkout/orders';
    /**
     * cUrl handler
     * @var resource
     */
    private $handler = null;
    /**
     *
     * @var type FormatHttpResponse result
     */
    public $result;

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

    public function getOrderUrl() {
        return $this->orderUrl;
    }

    public function apply($method, $data = NULL) {
        if ($method == 'POST') {
            $json = json_encode($data);
            curl_setopt($this->handler,CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
            curl_setopt($this->handler, CURLOPT_HEADER, true);//to get headers in response
            curl_setopt($this->handler, CURLOPT_URL, $this->svea_connection_url);
            curl_setopt($this->handler, CURLOPT_POST, true);
            curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);//set to get response
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $json);
            //process the headers to readable format. TODO: Need it?
//            $curlHeaders = new FormatHttpResponse();
//            curl_setopt($this->handler, CURLOPT_HEADERFUNCTION,  array(&$curlHeaders, 'processHeader'));

            $response = $this->execute();
            $info = $this->getInfo();
            $error = $this->getError();
            $this->close();

            if ($response === false || $info === false) {
                throw new Exception(
                "Connection to '{$this->svea_connection_url}' failed: {$error}"
                );
            }
            $this->orderUrl = $response;//-> get url
            return $info;



//            $header_result_array = $curlHeaders->getHeaders();
//              return $header_result_array;
            //TODO: create class to handle response. params info, error and response

            //force curl to trust https
//            curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, 2);
//            curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, true);

             // Set HTTP Headers wich ones to set?
//        $request->setHeader('User-Agent', (string)$this->userAgent());
//        $request->setHeader('Authorization', "Svea {$digest}");
//        $request->setHeader('Accept', $resource->getContentType());
//        if (strlen($payload) > 0) {
//            $request->setHeader('Content-Type', $resource->getContentType());
//            $request->setData($payload);
//        }
        } elseif ($method == 'GET') {
            curl_setopt($this->handler,CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
            curl_setopt($this->handler, CURLOPT_HEADER, true);//to get headers in response
            curl_setopt($this->handler, CURLOPT_URL, $this->orderUrl);
            curl_setopt($this->handler, CURLOPT_POST, true);
            curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);//set to get response
//            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $json);
            //process the headers to readable format. TODO: Need it?
//            $curlHeaders = new FormatHttpResponse();
//            curl_setopt($this->handler, CURLOPT_HEADERFUNCTION,  array(&$curlHeaders, 'processHeader'));

            $response = $this->execute();
            $info = $this->getInfo();
            $error = $this->getError();
            $this->close();

            if ($response === false || $info === false) {
                throw new Exception(
                "Connection to '{$this->svea_connection_url}' failed: {$error}"
                );
            }
            return $response;
        }
    }
}