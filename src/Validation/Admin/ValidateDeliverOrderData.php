<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateDeliverOrderData extends ValidationService
{
    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'orderid', 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');

        $this->mustBeSet($data, 'orderrowids', 'Order Id');
        $this->mustNotBeEmptyArray($data['orderrowids'], 'Order Row Ids');
        foreach ($data['orderrowids'] as $orderRowId) {
            $this->mustBeInteger($orderRowId, 'Order Row Id');
        }
    }
}
