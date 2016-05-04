<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;

abstract class ImplementationManager implements ImplementationInterface
{
    /**
     * Transport connector used to make HTTP request to Svea Checkout API.
     *
     * @var Connector $connector
     */
    protected $connector;

    /**
     * API response content - json
     *
     * @var string $response
     */
    protected $response;

    /**
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param array $data
     */
    public function execute($data)
    {
        $this->validateData($data);
        $this->mapData($data);
        $this->prepareData();
        $this->invoke();
    }

    public abstract function validateData($data);

    public abstract function mapData($data);

    public abstract function prepareData();

    public abstract function invoke();

    /**
     * Return API response content
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
}
