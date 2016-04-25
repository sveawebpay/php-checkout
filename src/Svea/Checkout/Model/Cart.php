<?php

namespace Svea\Checkout\Model;

class Cart
{
    /**
     * @var array OrderRow []
     */
    private $items = array();


    /**
     * @return OrderRow
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param OrderRow $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }
}
