<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Implementation\ImplementationManager;

abstract class AdminImplementationManager extends ImplementationManager
{
    protected function prepareUrl($data)
    {
        if (!is_array($data)) {
            $data = array($data);
        }

        return $this->connector->getBaseApiUrl() . vsprintf($this->apiUrl, $data);
    }
}