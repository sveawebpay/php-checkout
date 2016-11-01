<?php

namespace Svea\Checkout\Validation;

/**
 * Class ValidateGetOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateGetOrderData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeInteger($data, 'Order Id');
    }
}
