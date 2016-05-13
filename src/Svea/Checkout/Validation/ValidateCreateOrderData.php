<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;

/**
 * Class ValidateCreateOrderData
 * @package Svea\Checkout\Validation
 */
class ValidateCreateOrderData implements ValidationInterface
{
    /**
     * @param array $data
     * @throws SveaInputValidationException If data is invalid
     */
    public function validate($data)
    {
        $this->validateGeneralData($data);
        $this->validateMerchant($data);
        $this->validateOrderCart($data);
    }

    /**
     * @param array $data
     * @throws SveaInputValidationException
     */
    private function validateGeneralData($data)
    {
        if (!is_array($data)) {
            throw new SveaInputValidationException(
                'Order data should be array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $requiredFields = array('merchantSettings',  'cart', 'locale', 'currency', 'countrycode');

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
     * @param array $data
     * @throws SveaInputValidationException
     */
    private function validateMerchant($data)
    {
        if (!isset($data['merchantSettings']) || !is_array($data['merchantSettings'])) {
            throw new SveaInputValidationException(
                'Merchant "merchantSettings" array should be passed as array!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $merchantData = $data['merchantSettings'];
        $requiredFields = array('termsuri', 'checkouturi', 'confirmationuri', 'pushuri');

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
