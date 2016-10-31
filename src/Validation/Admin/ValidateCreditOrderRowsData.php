<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationInterface;

class ValidateCreditOrderRowsData implements ValidationInterface
{

    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->validateOrderId($data);
        $this->validateDeliveryId($data);
        $this->validateListOfRowIds($data);
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

        if (!is_int($data['orderid'])) {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }

    private function validateDeliveryId($data)
    {
        if (!isset($data['deliveryid'])) {
            throw new SveaInputValidationException(
                'Delivery ID should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!is_int($data['deliveryid'])) {
            throw new SveaInputValidationException(
                'Delivery ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }

    private function validateListOfRowIds($data)
    {
        if (!isset($data['orderrowids'])) {
            throw new SveaInputValidationException(
                'Order Row Ids should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!is_array($data['orderrowids'])) {
            throw new SveaInputValidationException(
                'Order Row Ids should be passed like array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        foreach ($data['orderrowids'] as $orderRowId) {
            if (!is_int($orderRowId)) {
                throw new SveaInputValidationException(
                    'Order Row Id should be passed like array!',
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }
    }
}