<?php

namespace Svea\Checkout\Validation;

/**
 * Class ValidateUpdateOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateUpdateTokenData extends ValidationService
{
    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'token', 'Token');
        $this->mustBeString($data['token'], 'Token');

        $this->mustBeSet($data, 'status', 'Status');
        $this->mustBeString($data['status'], 'Status');
    }
}
