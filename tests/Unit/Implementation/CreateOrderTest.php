<?php

namespace Svea\Checkout\Tests\Unit\Transport;

use Svea\Checkout\Implementation\CreateOrder;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Tests\Unit\TestCase;

class CreateOrderTest extends TestCase
{
    public function testMapData()
    {
        $co = new CreateOrder($this->connector);

        $co->mapData($this->inputData);

        /**
         * @var CheckoutData $checkoutData
         */
        $checkoutData = $co->getCheckoutData();

        $this->assertEquals($this->inputData['locale'], $checkoutData->getLocale());
        $this->assertEquals($this->inputData['purchase_country'], $checkoutData->getCountryCode());
        $this->assertEquals($this->inputData['purchase_currency'], $checkoutData->getCurrency());

        $merchantSettings = $checkoutData->getMerchantSettings();
        $merchantData = $this->inputData['merchant_urls'];

        $this->assertEquals($merchantData['terms'], $merchantSettings->getTermsUri());
        $this->assertEquals($merchantData['checkout'], $merchantSettings->getCheckoutUri());
        $this->assertEquals($merchantData['confirmation'], $merchantSettings->getConfirmationUri());
        $this->assertEquals($merchantData['push'], $merchantSettings->getPushUri());

        $orderLines = $this->inputData['order_lines'];
        $cart = $checkoutData->getCart();
        $items = $cart->getItems();

        foreach ($orderLines as $i => $orderLine) {
            /**
             * @var OrderRow $orderRow
             */
            $orderRow = $items[$i];

            $this->assertEquals($orderLine['articlenumber'], $orderRow->getArticleNumber());
            $this->assertEquals($orderLine['discountpercent'], $orderRow->getDiscountPercent());
            $this->assertEquals($orderLine['name'], $orderRow->getName());
            $this->assertEquals($orderLine['quantity'], $orderRow->getQuantity());
            $this->assertEquals($orderLine['unitprice'], $orderRow->getUnitPrice());
            $this->assertEquals($orderLine['vatpercent'], $orderRow->getVatPercent());
        }
    }

//    public function testPrepareData()
//    {
//
//    }
}
