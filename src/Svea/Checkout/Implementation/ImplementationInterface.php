<?php

namespace Svea\Checkout\Implementation;

/**
 * Interface ImplementationInterface
 * @package Svea\Checkout\Implementation
 */
interface ImplementationInterface
{
    /**
     * Template pattern for all implementations
     * @param mixed $data
     */
    public function execute($data);

    /**
     * @return mixed
     */
    public function getResponse();
}
