<?php

namespace Svea\Checkout\Validation;

interface ValidationInterface
{
    /**
     * @param $data
     */
    public function validate($data);
}