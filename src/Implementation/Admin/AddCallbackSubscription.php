<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class AddCallbackSubscription extends AdminImplementationManager
{
    protected $apiUrl = '/api/v2/callbacks/subscriptions';

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
        $requestData = array(
            'CallbackUri' => $data['callbackuri'],
            'Events' => array_values($data['events'])
        );

        if (array_key_exists('secret', $data)) {
            $requestData['Secret'] = $data['secret'];
        }

        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setBody(json_encode($requestData));
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
