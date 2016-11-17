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
     * @param array $data Input data to Svea Checkout Library
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
        $requestData = array();
        if (isset($data['orderrowids'])) {
            $requestData['orderRowIds'] = $data['orderrowids'];
        } elseif (isset($data['newcreditrow'])) {
            $requestData['newCreditRow'] = $data['newcreditrow'];
        }

        $orderId = $data['orderid'];
        $deliveryId = $data['deliveryid'];
        $urlParams = array($orderId, $deliveryId);

        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setBody(json_encode($requestData));
        $this->requestModel->setApiUrl($this->prepareUrl($urlParams));
    }

    /**
     * Invoke Api call
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
