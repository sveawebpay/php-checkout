<?php
/**
 * Do REST calls for the order
 * implements ArrayAccess interface to access the data containing the order as Array
 */
class SveaCheckoutOrder implements ArrayAccess {

    /**
     * Connector
     * @var Svea_Connector
     */
    public $connector;

    private $orderUrl;

    private $data = array();


    public function __construct(SveaCheckoutConnector $connector) {
        $this->connector = $connector;
    }
    /**
     * Get the URL of the resource
     *
     * @return string
     */
    public function getOrderUrl() {
        return $this->orderUrl;
    }

    /**
     * Set the URL of the resource
     *
     * @param string $orderUrl URL of the resource
     *
     * @return void
     */
    public function setOrderUrl($orderUrl) {
        $this->orderUrl = strval($orderUrl);
    }
    /**
     * Create order
     * @param type array of data
     * @return type http info
     */
    public function create($data) {
        return $this->connector->apply('POST', $this, $data);
    }

    /**
     * Get order
     * @return type
     */
    public function get() {
        return $this->connector->apply('GET', $this, NULL, $this->orderUrl);
    }

     public function update($data, $orderUrl) {
         $this->orderUrl = $orderUrl;
         $this->connector->apply('POST', $this, $data, $this->orderUrl);
    }

    public function parse(array $data) {
        $this->data = $data;
    }
    /**
     * Abstract ArrayAccess method
     * @param type $key
     * @return type
     */
    public function offsetExists($key) {
         return array_key_exists($key, $this->data);
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

        return $this->data[$key];
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
     * @param type $key
     * @throws Exception
     */
    public function offsetUnset($key) {
        throw new Exception("Unset of $key not supported.");
    }

}