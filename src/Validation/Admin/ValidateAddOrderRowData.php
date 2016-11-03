<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateAddOrderRowData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeInteger($data['id'], 'Order Id');

        $this->mustBeSet($data, 'orderrow', 'Order Row');
        $this->mustBeArray($data['orderrow'], 'Order Row');
    }
}
