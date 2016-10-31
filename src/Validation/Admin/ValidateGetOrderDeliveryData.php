<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Validation\ValidationInterface;
use Svea\Checkout\Exception\SveaInputValidationException;

class ValidateGetOrderDeliveryData implements ValidationInterface
{
	/**
	 * @param mixed $data
	 */
	public function validate($data)
	{
        if (!is_numeric($data))
        {
            throw new SveaInputValidationException(
                'Order ID should be passed like integer!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
	}
}