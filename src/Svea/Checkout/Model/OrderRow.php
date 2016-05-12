<?php

namespace Svea\Checkout\Model;

class OrderRow
{
    /**
     * @var string $articleNumber
     */
    private $articleNumber;

    /**
     * Name of the product
     *
     * @var string $name
     */
    private $name;

    /**
     * Quantity of the product.
     *
     * @var int $quantity
     */
    private $quantity;

    /**
     * Price of the product, given in minor currency.
     *
     * @var int $unitPrice
     */
    private $unitPrice;

    /**
     * The discount of the product, given in minor currency.
     *
     * @var int $discountPercent
     */
    private $discountPercent;

    /**
     * The VAT percentage of the current product.
     *
     * @var int $vatPercent
     */
    private $vatPercent;

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
     * Set class parameters for existing parameters in passed list
     * @param array $data
     */
    public function setItemParameters($data)
    {
        if (isset($data['articlenumber'])) {
            $this->articleNumber = $data['articlenumber'];
        }

        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['quantity'])) {
            $this->quantity = $data['quantity'];
        }

        if (isset($data['unitprice'])) {
            $this->unitPrice = $data['unitprice'];
        }

        if (isset($data['discountpercent'])) {
            $this->discountPercent = $data['discountpercent'];
        }

        if (isset($data['vatpercent'])) {
            $this->vatPercent = $data['vatpercent'];
        }
    }


    /**
     * Return array of set class items
     * @return array
     */
    public function getItemParameters()
    {
        $preparedData = array();

        if ($this->articleNumber != null) {
            $preparedData['articlenumber'] = $this->articleNumber;
        }

        if ($this->name != null) {
            $preparedData['name'] = $this->name;
        }

        if ($this->quantity != null) {
            $preparedData['quantity'] = $this->quantity;
        }

        if ($this->unitPrice != null) {
            $preparedData['unitprice'] = $this->unitPrice;
        }

        if ($this->discountPercent != null) {
            $preparedData['discountpercent'] = $this->discountPercent;
        }

        if ($this->vatPercent != null) {
            $preparedData['vatpercent'] = $this->vatPercent;
        }

        return $preparedData;
    }
}
