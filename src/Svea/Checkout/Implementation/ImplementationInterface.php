<?php

namespace Svea\Checkout\Implementation;

/**
 * Interface ImplementationInterface
 * @package Svea\Checkout\Implementation
 */
interface ImplementationInterface
{
    public function execute($data);

    public function getResponse();
}
