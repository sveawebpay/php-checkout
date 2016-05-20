<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\SveaInputValidationException;

class GetOrder extends ImplementationManager
{
    const API_URL = '/api/orders/';

    /**
     * Request body - JSON
     *
     * @var Request $requestModel
     */
    private $requestModel;

    /**
     * @param $data
     * @throws SveaInputValidationException
     */
    public function validateData($data)
    {
        $validator = $this->validator;
        $validator->validate($data);
    }

    /**
     * Prepare body data for Api call
     *
     * @param mixed $orderId
     */
    public function prepareData($orderId)
    {
        $this->requestModel = new Request();
        $this->requestModel->setGetMethod();
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL . $orderId);
    }

    /**
     * Invoke request call
     *
     * @throws SveaApiException
     */
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
