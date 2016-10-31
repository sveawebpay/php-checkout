<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationInterface;

class ValidateGetOrderData implements ValidationInterface
{
    /**
     * @param integer $data
     * @throws SveaInputValidationException If data is invalid
     */
    public function validate($data)
    {
        if (!is_numeric($data)) {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}