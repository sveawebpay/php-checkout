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

        $this->mustBeSet($data, 'orderid', 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');

        $this->mustBeSet($data, 'deliveryid', 'Delivery Id');
        $this->mustBeInteger($data['deliveryid'], 'Delivery Id');
    }

    private function validateListOfRowIds($data)
    {
        $this->mustBeSet($data, 'orderrowids', 'Order Row Ids');
        $this->mustNotBeEmptyArray($data['orderrowids'], 'Order Row Ids');

        foreach ($data['orderrowids'] as $orderRowId) {
            $this->mustBeInteger($orderRowId, 'Order Row Id');
        }
    }
}
