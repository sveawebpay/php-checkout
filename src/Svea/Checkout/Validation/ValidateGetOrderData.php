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
     * @param int $data
     * @throws SveaInputValidationException If data is invalid
     */
    public function validate($data)
    {
        $id = intval($data);
        if ($id === 0) {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}
