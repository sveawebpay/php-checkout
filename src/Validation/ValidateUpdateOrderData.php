<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

/**
 * Class ValidateUpdateOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateUpdateOrderData extends ValidationService
{
    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'id', 'Order Id');
        $this->mustBeInteger($data['id'], 'Order Id');
    }
}
