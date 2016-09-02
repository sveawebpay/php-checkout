<?php

namespace Svea\Checkout\Implementation;

final class FormatInputData
{
    public static function formatArrayKeysToLower($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        return self::lowerArrayKeys($data);
    }

    private static function lowerArrayKeys(array $input)
    {
        $return = array();

        foreach ($input as $key => $value) {
            $key = strtolower($key);

            if (is_array($value)) {
                $value = self::lowerArrayKeys($value);
            }

            $return[$key] = $value;
        }

        return $return;
    }
}
