<?php

namespace Svea\Checkout\Validation;

interface ValidationInterface
{
    /**
     * @param mixed $data
     */
    public function validate($data);
}
