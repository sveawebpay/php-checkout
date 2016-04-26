<?php

namespace Svea\Checkout\Implementation;

/**
 * Interface ImplementationInterface
 * @package Svea\Checkout\Implementation
 */
interface ImplementationInterface
{
    public function prepareData();

    public function mapData($data);

    public function invoke();

    public function mapDataBack();
}
