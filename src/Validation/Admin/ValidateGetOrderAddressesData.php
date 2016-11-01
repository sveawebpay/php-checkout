<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateGetOrderAddressesData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'id', 'Order Id');
        $this->mustBeInteger($data['id'], 'Order Id');

        if (isset($data['addressid']) && $data['addressid'] != '') {
            $this->mustBeInteger($data['addressid'], 'Address Id');
        }
    }
}