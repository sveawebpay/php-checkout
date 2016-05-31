<?php

/**
 * Svea Connection library for @todo NAME ON CHECKOUT
 *
 *
 * Copyright 2016 Svea Ekonomi AB
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category Payment
 * @package Svea_Checkout
 * @author Svea Ekonomi AB <support-webpay@sveaekonomi.se>
 * @copyright 2016 Svea Ekonomi AB
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache license v2.0
 */
namespace Svea\Checkout;

use Svea\Checkout\Implementation\ImplementationFactory;
use Svea\Checkout\Transport\Connector;

/**
 * Class CheckoutClient
 *
 * @package Svea\Checkout
 * @author Svea
 */
class CheckoutClient
{
    /**
     * Transport connector used to make HTTP request to Svea Checkout API.
     *
     * @var Connector
     */
    private $connector;

    /**
     * CheckoutClient constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Create new Svea Checkout order.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $createOrder = ImplementationFactory::returnCreateOrderClass($this->connector);
        $createOrder->execute($data);

        return $createOrder->getResponse();
    }

    /**
     * Update existing Svea Checkout order.
     *
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        $updateOrder = ImplementationFactory::returnUpdateOrderClass($this->connector);
        $updateOrder->execute($data);

        return $updateOrder->getResponse();
    }

    /**
     * Return Svea Checkout order data.
     *
     * @param int $data
     * @return mixed
     */
    public function get($data)
    {
        $getOrder = ImplementationFactory::returnGetOrderClass($this->connector);
        $getOrder->execute($data);

        return $getOrder->getResponse();
    }

    /**
     * Return Svea Checkout Order Subsystem information.
     *
     * @param int $data
     * @return mixed
     */
    public function getOrderSubsystemInfo($data)
    {
        $getOrder = ImplementationFactory::returnGetOrderSubsystemClass($this->connector);
        $getOrder->execute($data);

        return $getOrder->getResponse();
    }
}
