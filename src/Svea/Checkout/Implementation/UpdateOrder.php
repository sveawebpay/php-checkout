<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;

class UpdateOrder extends ImplementationManager
{
    const API_URL = '/api/orders/';

    /**
     * @var int
     */
    private $orderId;

    /**
     * Request body - JSON
     *
     * @var string $requestBodyData
     */
    private $requestBodyData;

    /**
     * @param $data
     * @throws \Svea\Checkout\Exception\SveaInputValidationException
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

    public function invoke()
    {
        $requestModel = new Request();
        $requestModel->setPutMethod();
        $requestModel->setBody($this->requestBodyData);
        $requestModel->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL . $this->orderId);

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
