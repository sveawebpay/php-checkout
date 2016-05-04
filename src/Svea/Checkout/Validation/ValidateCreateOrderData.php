<?php

namespace Svea\Checkout\Validation;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaOrderException;

class ValidateCreateOrderData implements ValidationInterface
{

    /**
     * @param $data
     * @throws SveaOrderException
     */
    public function validate($data)
    {
        if (!is_array($data)) {
            throw new SveaOrderException('Order data should be array !', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }

        // - merchant url check
        if (!isset($data['merchant_urls'])) {
            throw new SveaOrderException('"merchant_urls" array should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }
        if (!isset($data['merchant_urls']['terms'])) {
            throw new SveaOrderException('Merchant "terms" url should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }
        if (!isset($data['merchant_urls']['checkout'])) {
            throw new SveaOrderException('Merchant "checkout" url should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }
        if (!isset($data['merchant_urls']['confirmation'])) {
            throw new SveaOrderException('Merchant "confirmation" url should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }
        if (!isset($data['merchant_urls']['push'])) {
            throw new SveaOrderException('Merchant "push" url should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }


        // - order data check
        if (!isset($data['order_lines']) || !is_array($data['order_lines'])) {
            throw new SveaOrderException('Order lines should be passed as array!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
        }

        // - row items check
        $orderLines = $data['order_lines'];
        foreach ($orderLines as $row) {

            if (!isset($row['articlenumber'])) {
                throw new SveaOrderException('Order row "articlenumber" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
            if (!isset($row['discountpercent'])) {
                throw new SveaOrderException('Order row "discountpercent" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
            if (!isset($row['name'])) {
                throw new SveaOrderException('Order row "name" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
            if (!isset($row['quantity'])) {
                throw new SveaOrderException('Order row "quantity" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
            if (!isset($row['unitprice'])) {
                throw new SveaOrderException('Order row "unitprice" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
            if (!isset($row['vatpercent'])) {
                throw new SveaOrderException('Order row "vatpercent" should be passed!', ExceptionCodeList::INPUT_VALIDATION_ERROR);
            }
        }


        // - localization check
        if (!isset($data['locale']))
            throw new SveaOrderException('"locale should be passed"!', ExceptionCodeList::INPUT_VALIDATION_ERROR);

        if (!isset($data['purchase_currency']))
            throw new SveaOrderException('"purchase_currency" should be passed', ExceptionCodeList::INPUT_VALIDATION_ERROR);

        if (!isset($data['purchase_country']))
            throw new SveaOrderException('"purchase_country" should be passed', ExceptionCodeList::INPUT_VALIDATION_ERROR);
    }
}