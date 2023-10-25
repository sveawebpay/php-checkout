<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateDeliverOrderWithLowerAmountData extends ValidationService
{
    /**
	 * Validate the provided data
	 * 
     * @param array $data
	 * 
	 * @return void
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'orderid', 'Order Id');
        $this->mustBeInteger($data['orderid'], 'Order Id');

        $this->mustBeSet($data, 'deliveredamount', 'Delivered Amount');
        $this->mustBeInteger($data['deliveredamount'], 'Delivered Amount');
    }
}
