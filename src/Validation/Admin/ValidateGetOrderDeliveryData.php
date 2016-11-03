<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateGetOrderDeliveryData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'orderid', 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');

        if (isset($data['deliveryid'])) {
            $this->mustBeInteger($data['deliveryid'], 'Delivery Id');
        }
    }
}
