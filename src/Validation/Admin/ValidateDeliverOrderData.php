<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationInterface;

class ValidateDeliverOrderData implements ValidationInterface
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
        if (!isset($data['orderid'])) {
            throw new SveaInputValidationException(
                'Order ID should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!is_numeric($data['orderid'])) {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}