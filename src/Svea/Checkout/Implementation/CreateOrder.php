<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;

class CreateOrder extends ImplementationManager
{
    const API_URL = '/api/orders/';

    /**
     * Request body - JSON
     *
     * @var string $requestBodyData
     */
    private $requestBodyData;

    /**
     * Validate passed data
     *
     * @param mixed $data
     */
    public function validateData($data)
    {
        $validator = $this->validator;
        $validator->validate($data);
    }

    /**
     * Prepare date for request
     *
     * @param mixed $data
     */
    public function prepareData($data)
    {
        $this->requestBodyData = json_encode($data);
    }


    /**
     * Invoke request call
     *
     * @throws \Svea\Checkout\Exception\SveaApiException
     */
    public function invoke()
    {
        $requestModel = new Request();
        $requestModel->setPostMethod();
        $requestModel->setBody($this->requestBodyData);
        $requestModel->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL);

        $this->response = $this->connector->sendRequest($requestModel);
    }

    /**
     * @return string
     */
    public function getRequestBodyData()
    {
        return $this->requestBodyData;
    }

    /**
     * @param string $requestBodyData
     */
    public function setRequestBodyData($requestBodyData)
    {
        $this->requestBodyData = $requestBodyData;
    }
}
