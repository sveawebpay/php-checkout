<?php

namespace Svea\Checkout\Implementation;

use Svea\Checkout\Model\Cart;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\MerchantSettings;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Transport\RequestHandler;

class CreateOrder extends ImplementationManager
{
    const API_URL = 'api/orders/';

    /**
     * @var CheckoutData
     */
    private $checkoutData;


    public function mapData($data)
    {
        // - checkout data
        $checkoutData = new CheckoutData();

        // - merchant setting
        $merchantData = $data['merchant_urls'];
        $merchantSettings = new MerchantSettings();
        $merchantSettings->setTermsUri($merchantData['terms']);
        $merchantSettings->setCheckoutUri($merchantData['checkout']);
        $merchantSettings->setConfirmationUri($merchantData['confirmation']);
        $merchantSettings->setPushUri($merchantData['push']);

        $checkoutData->setMerchantSettings($merchantSettings);

        // - cart and order rows setting
        $cart = new Cart();

        $orderLines = $data['order_lines'];
        foreach ($orderLines as $orderLine) {
            $orderRow = new OrderRow();
            /*
             *  "articlenumber" => "123456789",
                "name" => "Dator",
                "quantity" => 200,
                "unitprice" => 12300,
                "discountpercent" => 1000,
                "vatpercent" => 2500
             * */

            $orderRow->setArticleNumber($orderLine['articlenumber']);
            $orderRow->setDiscountPercent('discountpercent');       // @todo check value
            $orderRow->setName($orderLine['name']);
            $orderRow->setQuantity($orderLine['quantity']);
            $orderRow->setUnitPrice($orderLine['unitprice']);
            $orderRow->setVatPercent('vatpercent');       // @todo check value

            $cart->addItem($orderRow);
        }

        $checkoutData->setCart($cart);

        $checkoutData->setLocale($data['locale']);

        $checkoutData->setCurrency($data['purchase_currency']);

        $checkoutData->setCountryCode($data['purchase_country']);


        $this->checkoutData = $checkoutData;
    }

    // - @todo rename it to validateData

    public function prepareData()
    {
        $checkoutData = $this->checkoutData;

        $merchantSettings = $checkoutData->getMerchantSettings();
        $cart = $checkoutData->getCart();

        $preparedData = array();
        $preparedData['merchantSettings'] = array(
            'termsuri' => $merchantSettings->getTermsUri(),
            'checkouturi' => $merchantSettings->getCheckoutUri(),
            'confirmationuri' => $merchantSettings->getConfirmationUri(),
            'pushuri' => $merchantSettings->getPushUri()
        );

        $cartItems = $cart->getItems();
        foreach ($cartItems as $item) {
            /* @var $item OrderRow */
            $preparedData['cart'][] = array(
                'articlenumber' => $item->getArticleNumber(),
                'name' => $item->getName(),
                'quantity' => $item->getQuantity(),
                'unitprice' => $item->getUnitPrice(),
                'discountpercent' => $item->getDiscountPercent(),
                'vatpercent' => $item->getVatPercent()
            );
        }

        $preparedData['locale'] = $checkoutData->getLocale();
        $preparedData['countrycode'] = $checkoutData->getCountryCode();
        $preparedData['currency'] = $checkoutData->getCurrency();

        $this->requestBodyData = json_encode($preparedData);
    }

    public function invoke()
    {
        $request = new RequestHandler();
        $request->setPostMethod();
        $request->setBody($this->requestBodyData);
        $request->setApiUrl($this->connector->getApiUrl() . self::API_URL);

        $this->response = $this->connector->send($request);
    }

    public function mapDataBack()
    {
        return $this->response->getContent();

        // TODO: Implement mapDataBack() method.

    }
}
