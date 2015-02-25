<?php

class SveaCheckoutOrder {

    /**
     * Connector
     * @var Svea_Connector
     */
    public $connector;

    private $location;


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

}