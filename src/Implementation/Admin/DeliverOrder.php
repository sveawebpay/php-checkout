<?php

namespace Implementation\Admin;

use Svea\Checkout\Implementation\Admin\AdminImplementationManager;
use Svea\Checkout\Model\Request;

class DeliverOrder extends AdminImplementationManager
{
    protected $apiUrl = '/api/v1/orders/%d/deliveries';

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
     * Prepare body data for Api call
     * @param integer $orderId
     */
    public function prepareData($orderId)
    {
        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . $this->getUrlString($orderId));
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }
}