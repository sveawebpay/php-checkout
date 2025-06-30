<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\SveaInputValidationException;

/**
 * Class ValidateCreateOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateChangePaymentMethodData extends ValidationService
{
    /**
     * @param array $data
     * @throws SveaInputValidationException If data is invalid
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'token', 'Token');
    }
}
