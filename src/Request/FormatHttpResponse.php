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
   private $resource;
   private $status;
   private $data;

   /**
     * Initializes a new instance of the HTTP cURL class.
     */
    public function __construct() {
        $this->headers = array();
    }

    public function handleResponse( $resource, $status, $data) {
        switch ($status) {
            case 200: //The order was created successfully
                 $json = json_decode($data,TRUE);
                if ($json === null) {
                    throw new Exception('Could not read format as Json');
                }
//                print_r(get_class($resource));
                $resource->parse($json);

                break;

                case 201:
                    //TODO
                break;

            default:
                break;
        }

        $this->resource = $resource;
        $this->status = $status;
        $this->data = $data;

        return $this;
    }
     public function getStatus() {
        return $this->status;
    }
    public function getRequest() {
        return $this->resource;
    }
    public function getData() {
        return $this->data;
    }

    /**
     * Callback function for curl. Sets the headers array as key - value pairs.
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
}

?>
