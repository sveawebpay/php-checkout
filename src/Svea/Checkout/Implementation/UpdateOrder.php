<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Cart;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Validation\ValidateUpdateOrderData;

class UpdateOrder extends ImplementationManager
{
    const API_URL = '/api/orders/';

    /**
     * @var int
     */
    private $orderId;

    /**
     * @var CheckoutData
     */
    private $checkoutData;

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
        $validator = $this->validator;
        $validator->validate($data);
    }

    public function mapData($data)
    {
        $checkoutData = new CheckoutData();

        $this->orderId = $data['id'];

        $cart = new Cart();

        $orderLines = $data['order_lines'];
        foreach ($orderLines as $orderLine) {
            $orderRow = new OrderRow();
            $orderRow->setItemParameters($orderLine);

            $cart->addItem($orderRow);
        }

        $checkoutData->setCart($cart);

        $this->checkoutData = $checkoutData;
    }

    public function prepareData()
    {
        $cart = $this->checkoutData->getCart();

        $cartItems = $cart->getItems();
        $preparedData['cart'] = array();
        foreach ($cartItems as $item) {
            /* @var $item OrderRow */
            $preparedData['cart']['items'][] = $item->getItemParameters();
        }

        $this->requestBodyData = json_encode($preparedData);
    }

    public function invoke()
    {
        $requestModel = new Request();
        $requestModel->setPutMethod();
        $requestModel->setBody($this->requestBodyData);
        $requestModel->setApiUrl($this->connector->getBaseApiUrl() . self::API_URL . $this->orderId);

        $this->response = $this->connector->sendRequest($requestModel);
    }

    /**
     * @return Cart
     */
    public function getCheckoutData()
    {
        return $this->checkoutData;
    }

    /**
     * @param Cart $checkoutData
     */
    public function setCheckoutData($checkoutData)
    {
        $this->checkoutData = $checkoutData;
    }

    /**
     * @return string
     */
    public function getRequestBodyData()
    {
        return $this->requestBodyData;
    }

    /**
     * @param string $requestBodyData
     */
    public function setRequestBodyData($requestBodyData)
    {
        $this->requestBodyData = $requestBodyData;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }
}
