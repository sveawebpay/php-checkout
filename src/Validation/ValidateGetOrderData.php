<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

/**
 * Class ValidateGetOrderData
 * @package Svea\Checkout\Validation
 */
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
