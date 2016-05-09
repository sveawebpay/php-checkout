<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Validation\ValidationInterface;

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
     * @var ValidationInterface
     */
    protected $validator;

    /**
     * @param Connector $connector Used for authentication and connect with Svea Checkout API
     * @param ValidationInterface $validationInterface
     */
    public function __construct(Connector $connector, ValidationInterface $validationInterface)
    {
        $this->connector = $connector;
        $this->validator = $validationInterface;
    }

    /**
     * Template pattern for all implementations.
     * These are necessary steps for all implementations.
     *
     * @param mixed $data Input data to Svea Checkout Library
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
     * @param mixed $data Input data to Svea Checkout Library
     */
    abstract public function validateData($data);

    /**
     * @param mixed $data Input data to Svea Checkout Library
     */
    abstract public function mapData($data);

    /**
     * Prepare body data for Api call
     */
    abstract public function prepareData();

    /**
     * Invoke Api call
     */
    abstract public function invoke();
}
