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
   protected $headers;

   /**
     * Initializes a new instance of the HTTP cURL class.
     */
    public function __construct() {
        $this->headers = array();
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
