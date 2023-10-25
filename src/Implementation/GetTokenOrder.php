<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\SveaInputValidationException;

class GetTokenOrder extends ImplementationManager
{
    protected $apiUrl = '/api/tokens/%s/orders/%d/';

    /**
     * Request body - JSON
     *
     * @var Request $requestModel
     */
    private $requestModel;

    /**
     * @param array $data
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
     * @param array $data
     */
    public function prepareData($data)
    {
        $orderId = $data['orderid'];
        $token = $data['token'];
        $this->requestModel = new Request();
        $this->requestModel->setGetMethod();

        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . sprintf($this->apiUrl, $token, $orderId));
    }

    /**
     * Invoke request call
     *
     * @throws SveaApiException
     */
    public function invoke()
    {
        $this->responseHandler = $this->connector->sendRequest($this->requestModel);
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
