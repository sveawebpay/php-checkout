<?php

namespace Svea\Checkout\Validation;

/**
 * Class ValidateGetOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateGetTokenOrderData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'token', 'Token');
        $this->mustBeSet($data, 'orderid', 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');
    }
}
