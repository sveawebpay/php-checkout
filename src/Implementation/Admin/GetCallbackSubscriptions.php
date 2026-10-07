<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class GetCallbackSubscriptions extends AdminImplementationManager
{
    protected $apiUrl = '/api/v2/callbacks/subscriptions/';

    /**
     * @var Request
     */
    private $requestModel;

    public function validateData($data)
    {
        $this->validator->validate($data);
    }

    public function prepareData($data)
    {
        $this->requestModel = new Request();
        $this->requestModel->setGetMethod();
        $this->requestModel->setApiUrl($this->prepareUrl(array()));
    }

    public function invoke()
    {
        $this->responseHandler = $this->connector->sendRequest($this->requestModel);
    }

    public function getRequestModel()
    {
        return $this->requestModel;
    }

    public function setRequestModel($requestModel)
    {
        $this->requestModel = $requestModel;
    }
}
