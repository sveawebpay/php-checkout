<?php
$root = realpath(dirname(__FILE__));
require_once $root . '/../../src/Includes.php';

/**
 * Handle curl commands
 */
class SveaCurlHandler {
    /**
     * cUrl handler
     * @var resource
     */
    private $handler = null;
    /**
     *
     * @var type FormatHttpResponse result
     */
    public $result;

    /**
     * Do curl_init and create a new curl handler
     * @return curl handler
     */
    public function __construct() {
        $this->handler = curl_init();
    }
    /**
     * Get curl resource object
     * @return type
     */
    public function getResource() {
        return $this->handler;
    }

    /**
     * Do curl_exec
     * @return mixed response
     */
    public function execute() {
        return curl_exec($this->handler);
    }
    /**
     * Do curl_close
     * void
     */
    public function close() {
        curl_close($this->handler);
    }
    /**
     * Get Curl Error
     * @return type
     */
    public function getError() {
         return curl_error($this->handler);
    }
    /**
     * Get Curl Info
     * @return type
     */
    public function getInfo() {
        return curl_getinfo($this->handler);
    }


}