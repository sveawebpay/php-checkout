<?php

class SveaCheckoutOrder {

    /**
     * Connector
     * @var Svea_Connector
     */
    private $connector;


    public function __construct(SveaCurlHandler $connector) {
        $this->connector = $connector;
    }
    /**
     *
     * @param type array of data
     * @return type http info
     */
    public function create($data) {
        return $this->connector->apply('POST',$data);
    }

    public function get() {
        $url = $this->connector->getOrderUrl();
        return $this->connector->apply('GET', $url);
    }
}