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
     * @var Request $requestModel
     */
    private $requestModel;

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
        $this->requestModel = new Request();
        $this->requestModel->setPutMethod();
        $this->requestModel->setBody(json_encode($data));
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL . $this->orderId);
    }

    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }

    /**
     * @return Request
     */
    public function getRequestModel()
    {
        return $this->requestModel;
    }

    /**
     * @param Request $requestModel
     */
    public function setRequestModel($requestModel)
    {
        $this->requestModel = $requestModel;
    }
}
