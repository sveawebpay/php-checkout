<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Exception\ExceptionCodeList;
use Svea\Checkout\Exception\SveaInputValidationException;
use Svea\Checkout\Validation\ValidationService;

class ValidateCallbackSubscriptionData extends ValidationService
{
    /**
     * @var bool
     */
    private $isUpdate;

    public function __construct($isUpdate = false)
    {
        $this->isUpdate = $isUpdate;
    }

    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        if ($this->isUpdate) {
            $validator = new ValidateCallbackSubscriptionIdData();
            $validator->validate($data);
        }

        $this->mustBeSet($data, 'callbackuri', 'Callback Uri');
        if (!is_string($data['callbackuri'])
            || preg_match('//u', $data['callbackuri']) !== 1
            || filter_var($data['callbackuri'], FILTER_VALIDATE_URL) === false
            || strtolower((string) parse_url($data['callbackuri'], PHP_URL_SCHEME)) !== 'https'
        ) {
            throw new SveaInputValidationException(
                'Callback Uri must be a valid HTTPS URL!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }

        $this->mustBeSet($data, 'events', 'Events');
        $this->mustNotBeEmptyArray($data['events'], 'Events');
        foreach ($data['events'] as $event) {
            if (!is_string($event) || trim($event) === '' || preg_match('//u', $event) !== 1) {
                throw new SveaInputValidationException(
                    'Events must contain non-empty strings!',
                    ExceptionCodeList::INPUT_VALIDATION_ERROR
                );
            }
        }

        if (array_key_exists('secret', $data)
            && (!is_string($data['secret']) || preg_match('//u', $data['secret']) !== 1)
        ) {
            throw new SveaInputValidationException(
                'Secret must be passed as string!',
                ExceptionCodeList::INPUT_VALIDATION_ERROR
            );
        }
    }
}
