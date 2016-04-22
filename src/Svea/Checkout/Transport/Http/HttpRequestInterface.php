<?php


namespace Svea\Checkout\Transport\Http;


interface HttpRequestInterface
{
    public function setOption($name, $value);

    public function execute();

    public function getInfo($name);

    public function getError();

    public function close();
}