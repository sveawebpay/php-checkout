<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

class ValidateUpdateOrderData implements ValidationInterface
{
    /**
     * @param $data
     */
    public function validate($data)
    {
        $this->validateOrderId($data);
        $this->validateOrderItems($data);
    }

    /**
     * @param array $data
     * @throws SveaInputValidationException
     */
    public function validateOrderId($data)
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
    private function validateOrderItems($data)
    {
        if (!isset($data['order_lines']) || !is_array($data['order_lines'])) {
            throw new SveaInputValidationException(
                'Order lines should be passed as array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        foreach ($data['order_lines'] as $row) {
            $this->validateOrderItem($row);
        }
    }

    /**
     * @param array $itemData
     * @throws SveaInputValidationException
     */
    private function validateOrderItem($itemData)
    {
        if (!isset($itemData) || !is_array($itemData)) {
            throw new SveaInputValidationException(
                'Order item should be passed as array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $requiredFields = array('articlenumber', 'name', 'quantity', 'unitprice', 'vatpercent');

        foreach ($requiredFields as $field) {
            if (!isset($itemData[$field]) || $itemData[$field] === '') {
                throw new SveaInputValidationException(
                    "Order row \"$field\" should be passed!",
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }
    }
}
