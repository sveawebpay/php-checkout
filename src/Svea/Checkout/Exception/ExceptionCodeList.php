<?php

namespace Svea\Checkout\Exception;

class ExceptionCodeList
{
    const CLIENT_API_ERROR = 1000;

    const MISSING_MERCHANT_ID = 2001;
    const MISSING_SHARED_SECRET = 2002;
    const MISSING_API_BASE_URL = 2003;
    const INCORRECT_API_BASE_URL = 2004;

    const INPUT_VALIDATION_ERROR = 3000;

    const UNKNOWN_CODE_MESSAGE = 'Unknown code error';

    /**
     * Return Message for given exception code
     *
     * @param  $exceptionCode
     * @return string
     */
    public static function getErrorMessage($exceptionCode)
    {
        $exceptionCode = intval($exceptionCode);

        $exceptionMessageList = array(
            1000 => 'Api Client Error',

            2001 => 'Missing Merchant Id',
            2002 => 'Missing Shared Secret',
            2003 => 'Missing API Base URL',
            2004 => 'Incorrect API Base URL',

            3000 => 'Input Validation Error'
        );

        if (isset($exceptionMessageList[$exceptionCode])) {
            return $exceptionMessageList[$exceptionCode];
        }

        return self::UNKNOWN_CODE_MESSAGE;
    }
}
