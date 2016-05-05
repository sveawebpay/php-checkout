<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

class ValidateGetOrderData implements ValidationInterface
{
    /**
     * @param $data
     * @throws SveaInputValidationException
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
