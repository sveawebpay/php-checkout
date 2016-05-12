<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Request;
use Svea\Checkout\Exception\SveaApiException;
use Svea\Checkout\Exception\SveaInputValidationException;

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
     * @throws SveaInputValidationException
     */
    public function validateData($data)
    {
        $validator = $this->validator;
        $validator->validate($data);
    }

    /**
     * Prepare body data for Api call
     *
     * @param mixed $data
     */
    // @codingStandardsIgnoreLine
    public function prepareData($data){}

    /**
     * Invoke request call
     *
     * @throws SveaApiException
     */
    public function invoke()
    {
        $request = new Request();
        $request->setGetMethod();
        $request->setBody($this->requestBodyData);
        $request->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL . $this->orderId);

        $this->response = $this->connector->sendRequest($request);
    }
}
