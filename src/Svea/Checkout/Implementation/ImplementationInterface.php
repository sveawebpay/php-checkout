<?php

namespace Svea\Checkout\Implementation;

interface ImplementationInterface
{
    public function prepareData();

    public function mapData($data);

    public function invoke();

    public function mapDataBack();
}
