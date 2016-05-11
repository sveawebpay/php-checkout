<?php

namespace Svea\Checkout\Util;

class ScriptHandler
{
    const VENDOR_BIN_PATH = '/vendor/bin/';
    const SRC_PATH = '/src/';
    const TESTS_PATH = '/tests/';
    
    /**
     * Create log folder if folder does not exist
     */
    public static function createLogFolder()
    {
        if (!file_exists('build/logs')) {
            mkdir('build/logs', 0777, true);
        }
    }

    public static function codeAnalysisPhpLoc()
    {
        $rootPath = getcwd();
        $targetPath = $rootPath . '/build/logs/phploc.csv';
        $srcPath = $rootPath . self::SRC_PATH;
        $testsPath = $rootPath . self::TESTS_PATH;
        
        $command = $rootPath . self::VENDOR_BIN_PATH . "phploc  --log-csv $targetPath $srcPath $testsPath --quiet";

        exec($command);
//        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
//            exec($command);
//            echo 'This is a server using Windows!';
//        } else {
//            exec('vendor/bin/phploc --log-csv build/logs/phploc.csv src/ tests/ --quiet');
//            echo 'This is a server not using Windows!';
//        }
    }
}
