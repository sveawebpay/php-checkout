<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationInterface;

class ValidateCancelOrderRowData implements ValidationInterface
{

    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->validateOrderId($data);
        $this->validateOrderRowId($data);
        $this->validateIsCancelledField($data);
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

    /**
     * @param array $data
     * @throws SveaInputValidationException
     */
    private function validateOrderRowId($data)
    {
        if (!isset($data['orderrowid'])) {
            throw new SveaInputValidationException(
                'Order Row ID should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!is_numeric($data['orderrowid'])) {
            throw new SveaInputValidationException(
                'Order Row ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }

    /**
     * @param array $data
     * @throws SveaInputValidationException
     */
    private function validateIsCancelledField($data)
    {
        if (!isset($data['iscancelled'])) {
            throw new SveaInputValidationException(
                'isCancelled should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!is_bool($data['iscancelled'])) {
            throw new SveaInputValidationException(
                'isCancelled should be passed like boolean!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}