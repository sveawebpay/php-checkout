<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;

/**
 * Class ImplementationManager
 * @package Svea\Checkout\Implementation
 */
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

    /**
     * @param $data
     * @return mixed
     */
    abstract public function validateData($data);

    /**
     * @param $data
     * @return mixed
     */
    abstract public function mapData($data);

    /**
     * @return mixed
     */
    abstract public function prepareData();

    /**
     * @return mixed
     */
    abstract public function invoke();

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
