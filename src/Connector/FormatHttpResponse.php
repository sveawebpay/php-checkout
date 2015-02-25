<?php

/**
 * TODO: use this class?
 * Format http response to readable format
 */
class FormatHttpResponse {

    /**
    * Response headers, cleared for each request.
    *
    * @var array
    */
   private $headers;
   private $request;
   private $status;
   private $data;

   /**
     * Initializes a new instance of the HTTP cURL class.
     */
    public function __construct() {
        $this->headers = array();
    }



//    public function handleResponse( $request, array $headers, $status, $data) {
    public function handleResponse( $request, $status, $data) {
         $this->request = $request;
//        $this->headers = array();
//        foreach ($headers as $key => $value) {
//            $this->headers[strtolower($key)] = $value;
//        }
        $this->status = $status;
        $this->data = $data;

        return $this;
    }
     public function getStatus() {
        return $this->status;
    }
    public function getRequest() {
        return $this->request;
    }
    public function getData() {
        return $this->data;
    }

    /**
     * Set headers array
     * @param type curl result
     * @return int the number of bytes handled.
     */
    public function processHeader($curl, $header) {
        $curl = null;
        if ($header == false) {
            //there was a curl error throw exception
            throw new Exception('curl error');
        } else {
            //see if header
            $pos = strpos($header, ':');
            if ($pos === false) {
                return strlen($header);
            }
        $key = substr($header, 0, $pos);
        $value = trim(substr($header, $pos+1));
        $this->headers[$key] = trim($value);
        return strlen($header);
        }
    }

        /**
     * Gets the given key in header response.
     * @param type $name Description
     * @return header key
     */
    public function getHeaderValue($key = NULL) {
        foreach ($this->headers as $headerkey => $value) {
            if ($key == $headerkey) {
                return $value;
            }
        }
    }

    /**
     * Gets the accumulated headers.
     *
     * @return array
     */
    public function getHeaders($key = NULL)
    {
        return $this->headers;
    }
}

?>
