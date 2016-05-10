<?php

namespace Svea\Checkout\Model;

/**
 * Class Cart
 * @package Svea\Checkout\Model
 */
class Cart
{
    /**
     * Array with Order rows.
     *
     * @var array OrderRow []
     */
    private $items = array();


    /**
     * @return OrderRow []
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param OrderRow [] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param OrderRow $item
     */
    public function addItem($item)
    {
        $this->items[] = $item;
    }
}
