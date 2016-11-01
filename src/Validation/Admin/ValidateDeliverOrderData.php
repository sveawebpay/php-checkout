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
        $this->mustBeSet($data, $data['orderid'], 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');
    }
}