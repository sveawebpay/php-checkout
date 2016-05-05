<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Transport\RequestHandler;
use Svea\Checkout\Validation\ValidateGetOrderData;

class GetOrder extends ImplementationManager
{
    const API_URL = '/api/orders/';

    /**
     * @var int $orderId
     */
    private $orderId;

    /**
     * Request body - JSON
     *
     * @var string $requestBodyData
     */
    private $requestBodyData;

    /**
     * @param $data
     * @throws \Svea\Checkout\Exception\SveaInputValidationException
     */
    public function validateData($data)
    {
        $validation = new ValidateGetOrderData();
        $validation->validate($data);
    }

    /**
     * Map input data
     *
     * @param $data
     */
    public function mapData($data)
    {
        $this->orderId = intval($data);
    }

    /**
     * Prepare data for request
     */
    public function prepareData()
    {
        $preparedData['Id'] = $this->orderId;

        $this->requestBodyData = json_encode($preparedData);
    }

    /**
     * Invoke request call
     *
     * @throws \Svea\Checkout\Exception\SveaApiException
     */
    public function invoke()
    {
        $request = new RequestHandler();
        $request->setGetMethod();
        $request->setBody($this->requestBodyData);
        $request->setApiUrl($this->connector->getApiUrl() . self::API_URL . $this->orderId);

        $this->response = $this->connector->send($request);
    }
}
