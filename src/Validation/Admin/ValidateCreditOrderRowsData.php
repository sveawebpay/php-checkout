<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationService;

class ValidateCreditOrderRowsData extends ValidationService
{

    /**
     * @param array $data
     */
    public function validate($data)
    {
        // TODO - check about orderRowIds
        $this->validateListOfRowIds($data);

        $this->mustBeSet($data, $data['orderid'], 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');

        $this->mustBeSet($data, $data['deliveryid'], 'Delivery Id');
        $this->mustBeInteger($data['deliveryid'], 'Delivery Id');
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