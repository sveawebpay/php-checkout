<?php


namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateCreditOrderAmountData extends ValidationService
{

    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeInteger($data['orderid'], 'Order Id');

        $this->mustBeInteger($data['deliveryid'], 'Delivery Id');

        $this->mustBeInteger($data['amount'], 'Credit Amount');

        if (isset($data['orderrowids'])) {
            $this->mustBeArray($data['orderrowids'], 'Order Row Ids');
        }
    }
}
