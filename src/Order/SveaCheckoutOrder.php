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

    public function create(array $data) {
        $this->connector->apply('POST',$data);
    }
}