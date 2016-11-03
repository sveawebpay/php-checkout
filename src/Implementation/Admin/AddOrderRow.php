<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class AddOrderRow extends AdminImplementationManager
{
    /**
     * Set ApiUrl
     */
    protected function setApiUrl()
    {
        $this->apiUrl = '/api/v1/orders/%d/rows';
    }

    /**
     * Input data validation
     * @param mixed $data Input data to Svea Checkout Library
     */
    public function validateData($data)
    {
        $this->validator->validate($data);
    }

    /**
     * Prepare body data for Api call
     * @param mixed $data
     */
    public function prepareData($data)
    {
        $requestData = array();
        $requestData['orderRow'] = $data['orderrow'];

        $orderId = $data['id'];

        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setBody(json_encode($requestData));
        $this->requestModel->setApiUrl($this->prepareUrl($orderId));
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }
}
