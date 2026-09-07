<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationService;

class ValidateCallbackSubscriptionIdData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'subscriptionid', 'Subscription Id');
        $this->mustBeString($data['subscriptionid'], 'Subscription Id');

        if (preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/iD',
            $data['subscriptionid']
        ) !== 1) {
            throw new SveaInputValidationException(
                'Subscription Id must be a valid GUID!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}
