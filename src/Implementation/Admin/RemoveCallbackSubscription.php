<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class RemoveCallbackSubscription extends AdminImplementationManager
{
    protected $apiUrl = '/api/v2/callbacks/subscriptions/%s';

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
        $this->requestModel->setDeleteMethod();
        $this->requestModel->setApiUrl($this->prepareUrl(array($data['subscriptionid'])));
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
