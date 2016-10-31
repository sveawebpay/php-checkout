<?php


namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Validation\ValidationInterface;
use Svea\Checkout\Exception\SveaInputValidationException;

class ValidateGetOrderAddressesData implements ValidationInterface
{
    /**
     * @param mixed $data
     * @throws SveaInputValidationException
     */
	public function validate($data)
	{
		// - validate order id
		if (!is_numeric($data['id'])) {
			throw new SveaInputValidationException(
				'Order ID should be passed like integer!',
				ExceptionCodeList::INPUT_VALIDATION_ERROR
			);
		}


		if(isset($data['addressid']) && $data['addressid'] != '')
        {
            if (!is_numeric($data['addressid'])) {
                throw new SveaInputValidationException(
                    'Address ID, if passed, should be passed like integer!',
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }
	}
}