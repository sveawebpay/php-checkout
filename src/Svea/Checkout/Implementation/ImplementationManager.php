<?php


namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\Connector;

abstract class ImplementationManager implements ImplementationInterface
{
    /**
     * @var Connector $connector
     */
    protected $connector;

    protected $response;

    // - body data
    protected $requestBodyData;

    /**
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function execute($data)
    {
        $this->mapData($data);
        $this->prepareData();

        $this->invoke();
        $this->mapDataBack();
    }
}