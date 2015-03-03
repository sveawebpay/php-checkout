<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';
/**
 * Connect to Svea REST API
 */
class SveaCheckoutConnector {

    private $handler;
    public $svea_connection_url = 'http://sveawebpaycheckoutws.dev.svea.com/checkout/orders';

    /**
     * Apply curl
     * @param type $method
     * @param type $resource
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function apply($method, $resource, $data = NULL) {
         $this->handler = new SveaCurlHandler();

                // Set HTTP Headers wich ones to set?
//       curl_setopt($curl, 'User-Agent', (string)$this->userAgent());
//       curl_setopt($curl, 'Authorization', "Svea {$digest}");
//       curl_setopt($curl, 'Accept', $resource->getContentType());

        //get curl handler resource
        $curl = $this->handler->getResource();
        //create order
        if ($method == 'POST') {
            $json = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER , array('Content-Type: application/json'));
        //get order
        } elseif ($method == 'GET') {
            $this->svea_connection_url = $data;
        }
        curl_setopt($curl, CURLOPT_URL, $this->svea_connection_url);
//        curl_setopt($curl, CURLOPT_HEADER, true);//to get headers in response. Messes with the json message. Not needed?
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//set to get response

        $curlResponse = new FormatHttpResponse();
        //process the headers to readable format.
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,  array(&$curlResponse, 'processHeader'));

        $response = $this->handler->execute();
        $info = $this->handler->getInfo();
        $error = $this->handler->getError();
        $this->handler->close();
        if ($response === false || $info === false) {
            throw new Exception(
            "Connection to '{$this->svea_connection_url}' failed: {$error}"
            );
        }

        $resource->setOrderUrl($curlResponse->getHeaderValue('Location'));
        $result = $curlResponse->handleResponse(  $resource, intval($info['http_code']), strval($response));

        return $result;
    }

}