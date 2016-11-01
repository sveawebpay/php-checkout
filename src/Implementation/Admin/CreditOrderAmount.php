<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Model\Request;

class CreditOrderAmount extends AdminImplementationManager
{
    //URI: /api/v1/orders/{orderId}/deliveries/{deliveryId}/credits [POST]
    protected $apiUrl = '/api/v1/orders/%d/deliveries/%d/credits/%d';

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
        $requestData['amount'] = $data['amount'];
        $orderId = $data['orderid'];
        $deliveryId = $data['deliveryid'];
        $creditId = isset($data['creditId']) ? $data['creditid'] : '';

        $params = array($orderId, $deliveryId, $creditId);

        $this->requestModel = new Request();
        $this->requestModel->setGetMethod();
        $this->requestModel->setBody(json_encode($requestData));
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . $this->getUrlString($params));
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }
}
