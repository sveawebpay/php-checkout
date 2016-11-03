<?php


namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateGetOrderCreditsData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeInteger($data['orderid'], "Order Id");
        $this->mustBeInteger($data['deliveryid'], "Delivery Id");
    }
}
