<?php

namespace Svea\Checkout\Exception;

class ExceptionCodeList
{
    const CLIENT_API_ERROR = 1000;

    const MISSING_MERCHANT_ID = 2001;
    const MISSING_SHARED_SECRET = 2002;
    const MISSING_API_BASE_URL = 2003;
    const INCORRECT_API_BASE_URL = 2004;

    /**
     * Return Message for given exception code
     *
     * @param  $exceptionCode
     * @return mixed|string
     */
    public static function getErrorMessage($exceptionCode)
    {
        $exceptionCode = intval($exceptionCode);

        $exceptionMessageList = array(
            1000 => "Api Client Error",

            2001 => "Missing Merchant Id",
            2002 => 'Missing Shared Secret',
            2003 => "Missing API Base URL",
            2004 => "Incorrect API Base URL",
        );

        if (in_array($exceptionCode, $exceptionMessageList)) {
            return $exceptionMessageList[$exceptionCode];
        }

        return "Unknown code error";
    }
}
