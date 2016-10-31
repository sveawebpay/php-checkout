<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class CancelOrderRow extends AdminImplementationManager
{
    protected $apiUrl = '/api/v1/orders/%d/rows/%d';

    /**
     * Request body - JSON
     *
     * @var Request $requestModel
     */
    private $requestModel;

    /**
     * Input data validation
     * @param mixed $data Input data to Svea Checkout Library
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
        $requestData = array();
        $requestData['isCancelled'] = $data['iscancelled'];

        $orderId = $data['orderid'];
        $orderRowId = $data['orderrowid'];
        $urlParams = array($orderId, $orderRowId);

        $this->requestModel = new Request();
        $this->requestModel->setPatchMethod();
        $this->requestModel->setBody(json_encode($requestData));
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . $this->getUrlString($urlParams));
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }
}