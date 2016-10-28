<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Implementation\ImplementationManager;

abstract class AdminImplementationManager extends ImplementationManager
{
    protected function getUrlString($data)
    {
        if (!is_array($data)) {
            $data = array($data);
        }

        return vsprintf($this->apiUrl, $data);
    }
}