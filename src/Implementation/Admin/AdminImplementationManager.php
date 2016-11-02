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

        $url = vsprintf($this->apiUrl, $data);

        return $this->connector->getBaseApiUrl() . $url ;
    }
}
