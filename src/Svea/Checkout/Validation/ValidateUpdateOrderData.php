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
        $this->validateOrderCart($data);
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

        $id = intval($data['id']);
        if ($id === 0) {
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
    private function validateOrderCart($data)
    {
        if (!isset($data['cart']) || !is_array($data['cart'])) {
            throw new SveaInputValidationException(
                'Order lines should be passed as array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        if (!isset($data['cart']['items']) || !is_array($data['cart']['items'])) {
            throw new SveaInputValidationException(
                'Order lines should be passed as array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}
