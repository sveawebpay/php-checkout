<?php

namespace Svea\Checkout\Model;

/**
 * Class MerchantSettings
 * @package Svea\Checkout\Model
 */
class MerchantSettings
{
    /**
     * URI to the page with the terms.
     *
     * @var string $termsUri
     */
    private $termsUri;

    /**
     * URI to the page that contains the checkout.
     *
     * @var string $checkoutUri
     */
    private $checkoutUri;

    /**
     * URI to the page with the confirmation information for an order.
     *
     * @var string $confirmationUri
     */
    private $confirmationUri;

    /**
     * URI for Svea Callback service to post Created and Finished messages.
     *
     * @var string $pushUri
     */
    private $pushUri;

    /**
     * @return string
     */
    public function getTermsUri()
    {
        return $this->termsUri;
    }

    /**
     * @param string $termsUri
     */
    public function setTermsUri($termsUri)
    {
        $this->termsUri = $termsUri;
    }


    /**
     * @return string
     */
    public function getCheckoutUri()
    {
        return $this->checkoutUri;
    }

    /**
     * @param string $checkoutUri
     */
    public function setCheckoutUri($checkoutUri)
    {
        $this->checkoutUri = $checkoutUri;
    }

    /**
     * @return string
     */
    public function getConfirmationUri()
    {
        return $this->confirmationUri;
    }

    /**
     * @param string $confirmationUri
     */
    public function setConfirmationUri($confirmationUri)
    {
        $this->confirmationUri = $confirmationUri;
    }

    /**
     * @return string
     */
    public function getPushUri()
    {
        return $this->pushUri;
    }

    /**
     * @param string $pushUri
     */
    public function setPushUri($pushUri)
    {
        $this->pushUri = $pushUri;
    }
}
