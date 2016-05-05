<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

class ValidateCreateOrderData implements ValidationInterface
{

    /**
     * @param $data
     * @throws SveaInputValidationException
     */
    public function validate($data)
    {
        $this->validateGeneralData($data);
        $this->validateMerchant($data);
        $this->validateOrderItems($data);
    }

    private function validateGeneralData($data)
    {
        if (!is_array($data)) {
            throw new SveaInputValidationException(
                'Order data should be array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $requiredFields = array('locale', 'purchase_currency', 'purchase_country');

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                throw new SveaInputValidationException(
                    "Order \"$field\" should be passed!",
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }
    }


    /**
     * @param $data
     * @throws SveaInputValidationException
     */
    private function validateMerchant($data)
    {
        if (!isset($data['merchant_urls'])) {
            throw new SveaInputValidationException(
                'Merchant "merchant_urls" array should be passed!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $merchantData = $data['merchant_urls'];
        $requiredFields = array('terms', 'checkout', 'confirmation', 'push');

        foreach ($requiredFields as $field) {
            if (!isset($merchantData[$field]) || $merchantData[$field] === '') {
                throw new SveaInputValidationException(
                    "Merchant \"$field\" url should be passed!",
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }
    }


    /**
     * @param $data
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
     * @param $itemData
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

        $requiredFields = array('articlenumber', 'discountpercent', 'name', 'quantity', 'unitprice', 'vatpercent');

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
