<?php

namespace Svea\Checkout\Util;

/**
 * Class ScriptHandler
 * @package Svea\Checkout\Util
 */
class ScriptHandler
{
    /**
     * Create log folder if folder does not exist
     */
    public static function createLogFolder()
    {
        if (!file_exists('build/logs')) {
            mkdir('build/logs', 0777, true);
        }
    }
}
