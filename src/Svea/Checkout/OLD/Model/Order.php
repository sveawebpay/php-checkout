<?php
/**
 * Created by PhpStorm.
 * User: rs-savgaro-01
 * Date: 4/18/2016
 * Time: 10:10 AM
 */

namespace Svea\Checkout\Model;


class Order
{
    private $currency;

    /**
     * Order constructor.
     * @param $currency
     */
    public function __construct($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

}