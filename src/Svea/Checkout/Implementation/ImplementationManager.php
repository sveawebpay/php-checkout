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
     * @param Connector $connector Used for authentication and connect with Svea Checkout API
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Template pattern for all implementations.
     * These are necessary steps for all implementations.
     *
     * @param array $data Input data to Svea Checkout Library
     */
    public function execute($data)
    {
        $this->validateData($data);
        $this->mapData($data);
        $this->prepareData();
        $this->invoke();
    }

    /**
     * Return API response content
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $data Input data to Svea Checkout Library
     */
    abstract public function validateData($data);

    /**
     * @param array $data Input data to Svea Checkout Library
     */
    abstract public function mapData($data);

    abstract public function prepareData();

    abstract public function invoke();
}
