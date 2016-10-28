<?php

namespace Implementation\Admin;

use Svea\Checkout\Implementation\ImplementationManager;
use Svea\Checkout\Model\Request;

class DeliverOrder extends ImplementationManager
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
        // TODO: Implement validateData() method.
    }

    /**
     * Prepare body data for Api call
     * @param integer $orderId
     */
    public function prepareData($orderId)
    {
        $this->requestModel = new Request();
        $this->requestModel->setPostMethod();
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . sprintf($this->apiUrl, $orderId));
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        // TODO: Implement invoke() method.
    }
}