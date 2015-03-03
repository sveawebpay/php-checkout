<?php

class SveaCheckoutOrder implements ArrayAccess {

    /**
     * Connector
     * @var Svea_Connector
     */
    public $connector;

    private $location;

    private $_data = array();


    public function __construct(SveaCheckoutConnector $connector, $uri = null) {
        $this->connector = $connector;
         if ($uri !== null) {
            $this->setLocation($uri);
        }
    }
    /**
     * Get the URL of the resource
     *
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set the URL of the resource
     *
     * @param string $location URL of the resource
     *
     * @return void
     */
    public function setLocation($location) {
        $this->location = strval($location);
    }
    /**
     *
     * @param type array of data
     * @return type http info
     */
    public function create($data) {
        return $this->connector->apply('POST', $this, $data);
    }

    public function get() {
//        $resource = $this->connector->getResource();
//        print_r(gettype($resource));
        return $this->connector->apply('GET', $this, $this->location);
    }

    public function parse(array $data) {
        $this->_data = $data;
    }
    /**
     * Abstract ArrayAccess method
     * @param type $key
     * @return type
     */
    public function offsetExists($key) {
         return array_key_exists($key, $this->_data);
    }

    /**
     * Abstract ArrayAccess method
     * @param type $key
     * @return type
     * @throws Exception
     */
    public function offsetGet($key) {
        if (!is_string($key)) {
            throw new Exception("Key must be string");
        }

        return $this->_data[$key];
    }
    /**
     * Abstract ArrayAccess method
     * @param type $key
     * @param type $value
     * @throws Exception
     * @throws RuntimeException
     */
    public function offsetSet($key, $value) {
        if (!is_string($key)) {
            throw new Exception("Key must be string");
        }

        $value = print_r($value, true);
        throw new RuntimeException(
            "Use update function to change values. trying to set $key to $value"
        );
    }
    /**
     * Abstract ArrayAccess method
     * @param type $offset
     * @throws Exception
     */
    public function offsetUnset($offset) {
        throw new Exception("Unset of array not supported.");
    }

}