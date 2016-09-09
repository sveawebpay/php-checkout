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

namespace Svea\Checkout\Implementation;

class GetOrderSubsystemInfo extends GetOrder
{
    protected $apiUrl = '/api/orders/%d/subsystem';
}