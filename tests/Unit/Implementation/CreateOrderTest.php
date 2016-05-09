<?php

namespace Svea\Checkout\Tests\Unit\Implementation;

use Svea\Checkout\Implementation\CreateOrder;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Validation\ValidationInterface;

class CreateOrderTest extends TestCase
{
    /**
     * @var CreateOrder
     */
    protected $order;

    /**
     * @var ValidationInterface|\PHPUnit_Framework_MockObject_MockObject $validatorMock
     */
    protected $validatorMock;

    public function setUp()
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidateCreateOrderData')->getMock();
        $this->order = new CreateOrder($this->connectorMock, $this->validatorMock);
    }

    public function testMapData()
    {
        $createOrder = $this->order;
        $createOrder->mapData($this->inputCreateData);

        /**
         * @var CheckoutData $checkoutData
         */
        $checkoutData = $createOrder->getCheckoutData();

        $this->assertEquals($this->inputCreateData['locale'], $checkoutData->getLocale());
        $this->assertEquals($this->inputCreateData['purchase_country'], $checkoutData->getCountryCode());
        $this->assertEquals($this->inputCreateData['purchase_currency'], $checkoutData->getCurrency());

        $merchantSettings = $checkoutData->getMerchantSettings();
        $merchantData = $this->inputCreateData['merchant_urls'];

        $this->assertEquals($merchantData['terms'], $merchantSettings->getTermsUri());
        $this->assertEquals($merchantData['checkout'], $merchantSettings->getCheckoutUri());
        $this->assertEquals($merchantData['confirmation'], $merchantSettings->getConfirmationUri());
        $this->assertEquals($merchantData['push'], $merchantSettings->getPushUri());

        $orderLines = $this->inputCreateData['order_lines'];
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

    public function testPrepareData()
    {
        $createOrder = $this->order;
        $createOrder->setCheckoutData($this->checkoutData);

        $createOrder->prepareData();

        $requestBodyData = json_decode($createOrder->getRequestBodyData(), true);

        $this->assertEquals($requestBodyData['locale'], $this->checkoutData->getLocale());
        $this->assertEquals($requestBodyData['countrycode'], $this->checkoutData->getCountryCode());
        $this->assertEquals($requestBodyData['currency'], $this->checkoutData->getCurrency());

        $items = $requestBodyData['cart']['items'];
        /**
         * @var OrderRow[] $expectedItems
         */
        $expectedItems = $this->checkoutData->getCart()->getItems();
        $this->assertEquals($items[0]['articlenumber'], $expectedItems[0]->getArticleNumber());
        $this->assertEquals($items[0]['quantity'], $expectedItems[0]->getQuantity());

        $merchantSettings = $requestBodyData['merchantSettings'];
        $expectedMerchantSettings = $this->checkoutData->getMerchantSettings();
        $this->assertEquals($merchantSettings['termsuri'], $expectedMerchantSettings->getTermsUri());
        $this->assertEquals($merchantSettings['checkouturi'], $expectedMerchantSettings->getCheckoutUri());
        $this->assertEquals($merchantSettings['confirmationuri'], $expectedMerchantSettings->getConfirmationUri());
        $this->assertEquals($merchantSettings['pushuri'], $expectedMerchantSettings->getPushUri());
    }

    public function testInvoke()
    {
        $fakeResponse = 'Test response!!!';
        $this->connectorMock->expects($this->once())
            ->method('getBaseApiUrl');
        $this->connectorMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($fakeResponse));

        $createOrder = $this->order;
        $createOrder->setRequestBodyData(json_encode($this->checkoutData));
        $createOrder->invoke();

        $this->assertEquals($fakeResponse, $createOrder->getResponse());
    }

    public function testValidate()
    {
        $this->validatorMock->expects($this->once())
            ->method('validate');

        $getOrder = $this->order;

        $getOrder->validateData($this->inputCreateData);
    }
}
