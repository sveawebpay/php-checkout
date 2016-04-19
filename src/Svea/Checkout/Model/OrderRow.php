<?php

namespace Svea\Checkout\Model;


class OrderRow
{
    /**
     * @var string $articleNumber
     */
    private $articleNumber;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var int $quantity
     */
    private $quantity;

    /**
     * @var int $unitPrice
     */
    private $unitPrice;

    /**
     * @var int $discountPercent
     */
    private $discountPercent;

    /**
     * @var int $vatPercent
     */
    private $vatPercent;

    /**
     * @var string $unit
     */
    private $unit;


    /**
     * @return string
     */
    public function getArticleNumber()
    {
        return $this->articleNumber;
    }

    /**
     * @param string $articleNumber
     */
    public function setArticleNumber($articleNumber)
    {
        $this->articleNumber = $articleNumber;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return int
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * @param int $discountPercent
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return int
     */
    public function getVatPercent()
    {
        return $this->vatPercent;
    }

    /**
     * @param int $vatPercent
     */
    public function setVatPercent($vatPercent)
    {
        $this->vatPercent = $vatPercent;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }


}