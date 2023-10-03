<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;

class CreateTokenOrder extends ImplementationManager
{
    protected $apiUrl = '/api/tokens/%s/orders/';

    /**
     * Request body - JSON
     *
     * @var Request $requestModel
     */
    private $requestModel;

    /**
     * Validate passed data
     *
     * @param array $data
     */
    public function validateData($data)
    {
        $validator = $this->validator;
        $validator->validate($data);
    }

    /**
     * Prepare date for request
     *
     * @param array $data
     */
    public function prepareData($data)
    {
        $token = $data['token'];
        unset($data['token']);
        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setBody(json_encode($data));
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . sprintf($this->apiUrl, $token));
    }


    /**
     * Invoke request call
     *
     * @throws \Svea\Checkout\Exception\SveaApiException
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
