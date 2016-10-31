<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class CreditOrderRows extends AdminImplementationManager
{
    protected $apiUrl = '/api/v1/orders/%d/deliveries/%d/credits';

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
        $requestData['rowIds'] = $data['orderrowids'];

        $orderId = $data['orderid'];
        $deliveryId = $data['deliveryid'];
        $urlParams = array($orderId, $deliveryId);

        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
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