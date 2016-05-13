<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

/**
 * Class ValidateUpdateOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateUpdateOrderData implements ValidationInterface
{
    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->validateOrderId($data);
    }

    /**
     * @param array $data
     * @throws SveaInputValidationException
     */
    private function validateOrderId($data)
    {
        if (!isset($data['id'])) {
            throw new SveaInputValidationException(
                'Order ID should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (is_numeric($data['id'])) {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}
