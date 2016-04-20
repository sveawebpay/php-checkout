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
    protected $preparedData;

    protected $authorizationToken;

    /**
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function execute($data)
    {
        try
        {
            $this->validateData();
        }
        catch (\Exception $e)
        {
            return ReponseError($e);
        }

        $this->mapData($data);
        $this->prepareData();

        $this->createAuthorizationToken();

        $this->invoke();
        $this->mapDataBack();
    }

    private function createAuthorizationToken()
    {
        // TODO - implement concrete algorithm
        $this->authorizationToken = md5($this->connector->getMerchantId() . $this->connector->getSharedSecret() . $this->preparedData);
    }

    public function validateData()
    {
        if($b !== 1)
        {
            throw new \ValidationException("Nije dobar $b", 1234);
        }
    }
}