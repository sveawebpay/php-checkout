<?php

namespace Svea\Checkout\Validation\Admin;

use Svea\Checkout\Validation\ValidationService;

class ValidateGetDataFromLink extends ValidationService
{
    /**
     * @param mixed $url
     * @return bool
     */
    public function validate($url)
    {
        $this->mustBeString($url, 'Location link');
    }
}
