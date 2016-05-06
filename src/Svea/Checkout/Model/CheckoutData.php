<?php

namespace Svea\Checkout\Model;

class CheckoutData
{
    /**
     * @var
     */
    private $merchantSettings;

    /**
     * @var
     */
    private $cart;

    /**
     * @var
     */
    private $gui;

    /**
     * @var
     */
    private $pushUri;

    /**
     * @var
     */
    private $customer;

    /**
     * @var
     */
    private $shippingAddress;

    /**
     * @var
     */
    private $billingAddress;

    /**
     * @var
     */
    private $locale;

    /**
     * @var
     */
    private $currency;

    /**
     * @var
     */
    private $countryCode;

    /**
     * @var
     */
    private $populatedOrderIdentifiers;

    /**
     * @var
     */
    private $orderId;

    /**
     * @var
     */
    private $status;

    /**
     * @return MerchantSettings
     */
    public function getMerchantSettings()
    {
        return $this->merchantSettings;
    }

    /**
     * @param mixed $merchantSettings
     */
    public function setMerchantSettings($merchantSettings)
    {
        $this->merchantSettings = $merchantSettings;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getGui()
    {
        return $this->gui;
    }

    /**
     * @param mixed $gui
     */
    public function setGui($gui)
    {
        $this->gui = $gui;
    }

    /**
     * @return mixed
     */
    public function getPushUri()
    {
        return $this->pushUri;
    }

    /**
     * @param mixed $pushUri
     */
    public function setPushUri($pushUri)
    {
        $this->pushUri = $pushUri;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param mixed $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param mixed $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
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

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getPopulatedOrderIdentifiers()
    {
        return $this->populatedOrderIdentifiers;
    }

    /**
     * @param mixed $populatedOrderIdentifiers
     */
    public function setPopulatedOrderIdentifiers($populatedOrderIdentifiers)
    {
        $this->populatedOrderIdentifiers = $populatedOrderIdentifiers;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
