<?php

namespace Svea\Checkout\Tests\Unit;

use Svea\Checkout\Model\Cart;
use Svea\Checkout\Model\CheckoutData;
use Svea\Checkout\Model\MerchantSettings;
use Svea\Checkout\Model\OrderRow;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Transport\ApiClient;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\Http\HttpRequestInterface;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request $requestModel
     */
    protected $requestModel;

    /**
     * @var Connector|\PHPUnit_Framework_MockObject_MockObject $connectorMock
     */
    protected $connectorMock;

    /**
     * @var ApiClient|\PHPUnit_Framework_MockObject_MockObject $apiClientMock
     */
    protected $apiClientMock;

    /**
     * @var HttpRequestInterface|\PHPUnit_Framework_MockObject_MockObject $httpClientMock
     */
    protected $httpClientMock;

    /**
     * @var array $inputData
     */
    protected $inputData;

    /**
     * @var CheckoutData $checkoutData
     */
    protected $checkoutData;

    // Response
    protected $apiResponse;

    // Client Credentials
    protected $merchantId = '123456';
    protected $sharedSecret = '80e3a905e597ca428f4e25200433263c';
    protected $apiUrl = Connector::TEST_BASE_URL;

    // Request body data - Mock
    protected $orderData;

    protected function setUp()
    {
        $this->setOrderData();
        $this->setApiResponse();
        $this->setRequest();
        $this->setCurlRequest();
        $this->setApiClient();
        $this->setConnector();
        $this->setInputData();
        $this->setCheckoutData();
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    private function setRequest()
    {
        $this->requestModel = new Request();
        $this->requestModel->setApiUrl($this->apiUrl);
        $this->requestModel->setBody(json_encode($this->orderData));
        $this->requestModel->setPostMethod();
        $this->requestModel->setAuthorizationToken('123456789');
    }

    private function setCurlRequest()
    {
        $this->httpClientMock = $this->getMockBuilder('Svea\Checkout\Transport\Http\HttpRequestInterface')->getMock();
    }

    private function setApiClient()
    {
        $httpClientMock = $this->getMockBuilder('Svea\Checkout\Transport\Http\HttpRequestInterface')->getMock();
        $this->apiClientMock = $this->getMockBuilder('\Svea\Checkout\Transport\ApiClient')
            ->setConstructorArgs(array($httpClientMock))
            ->getMock();
    }

    private function setConnector()
    {
        $this->connectorMock = $this->getMockBuilder('Svea\Checkout\Transport\Connector')
            ->setConstructorArgs(array($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl))
            ->getMock();
    }

    private function setOrderData()
    {
        $this->orderData = array(
            "purchase_country" => "gb",
            "purchase_currency" => "gbp",
            "locale" => "en-gb",
            "order_amount" => 10000,
            "order_tax_amount" => 2000,
            "order_lines" => array(
                array(
                    "type" => "physical",
                    "reference" => "123050",
                    "name" => "Tomatoes",
                    "quantity" => 10,
                    "quantity_unit" => "kg",
                    "unit_price" => 600,
                    "tax_rate" => 2500,
                    "total_amount" => 6000,
                    "total_tax_amount" => 1200
                ),
                array(
                    "type" => "physical",
                    "reference" => "543670",
                    "name" => "Bananas",
                    "quantity" => 1,
                    "quantity_unit" => "bag",
                    "unit_price" => 5000,
                    "tax_rate" => 2500,
                    "total_amount" => 4000,
                    "total_discount_amount" => 1000,
                    "total_tax_amount" => 800
                )
            ),
            "merchant_urls" => array(
                "terms" => "http://www.merchant.com/toc",
                "checkout" => "http://www.merchant.com/checkout?klarna_order_id={checkout.order.id}",
                "confirmation" => "http://www.merchant.com/thank-you?klarna_order_id={checkout.order.id}",
                "push" => "http://www.merchant.com/create_order?klarna_order_id={checkout.order.id}"
            )
        );
    }

    private function setApiResponse()
    {
        $json = <<<JSON
        {
            "MerchantSettings":{
                "TermsUri":"http://localhost:51898/terms",
                "CheckoutUri":"http://localhost:51925/",
                "ConfirmationUri":"http://localhost:51925/checkout/confirm",
                "PushUri":"https://svea.com/push.aspx?sid=123&svea_order=123"
            },
            "Cart":{
                "Items":[
                    {
                        "ArticleNumber":"123456789",
                        "Name":"Dator",
                        "Quantity":200,
                        "UnitPrice":12300,
                        "DiscountPercent":1000,
                        "VatPercent":2500,
                        "Unit":null
                    },
                    {
                        "ArticleNumber":"SHIPPING",
                        "Name":"Shipping Fee",
                        "Quantity":100,
                        "UnitPrice":4900,
                        "DiscountPercent":0,
                        "VatPercent":2500,
                        "Unit":null
                    }
                ]
            },
            "Customer":null,
            "ShippingAddress":null,
            "BillingAddress":null,
            "Gui":{
                "Layout":"desktop",
                "Snippet":"<div id="svea-checkout-container" style="overflow-x: hidden;">
                <script type="text/javascript"> /* <![CDATA[ */ setTimeout((function(window, key ,containerId, document)
                { window[key] = window[key] || function () { (window[key].q = window[key].q || []).push(arguments); };
                window[key].config = { container: window.document.getElementById(containerId), ORDERID: '13',
                AUTHTOKEN:'SveaCheckout EH+0k2KjPEKvD16ObMmm8svZLZo=', //TESTDRIVE:true,
                //LAYOUT:'desktop', //LOCALE:'sv-se',
                //ORDER_STATUS:'checkout_incomplete', MERCHANTTERMSURI: '', MERCHANTTERMSTITLE: '', MERCHANTNAME: '',
                //GUI_OPTIONS:[], //ALLOW_SEPARATE_SHIPPING_ADDRESS: //false,
                //NATIONAL_IDENTIFICATION_NUMBER_MANDATORY: //false, //ANALYTICS:'UA-36053137-1',
                //PHONE_MANDATORY:false, //PACKSTATION_ENABLED:false, //PURCHASE_COUNTRY:'swe',
                //PURCHASE_CURRENCY:'sek',
                //BOOTSTRAP_SRC: 'http://testwpyweb01.sveaweb.se/checkout_test_mvc/scripts/checkout/checkout-loader.js'
                //BOOTSTRAP_SRC: 'http://localhost:51925/scripts/checkout/checkout-loader.js'
                BOOTSTRAP_SRC: 'http://webpaycheckout.test.svea.com//scripts/checkout/checkout-loader.js' };
                var scriptTag = document.createElement('script'); var container = document.getElementById(containerId);
                scriptTag.async = true; scriptTag.src = window[key].config.BOOTSTRAP_SRC;
                container.insertBefore(scriptTag, container.firstChild);
                // TODO: keep track of times when snippet loads for order...
                //try{ // p = w[k].config.BOOTSTRAP_SRC.split('/'); // p = p.slice(0, p.length - 1);
                // l = p.join('/') + // '/api/_tracking/v1/snippet/load?orderUrl=' +
                // w.encodeURIComponent(w[k].config.ORDER_URL) + '&' + // (new Date).getTime();
                // ((w.Image && (new w.Image))||(d.createElement&&d.createElement('img'))||{}).src=l; //}
                catch(e){} })(this,'_sveaCheckout','svea-checkout-container',document), 7000); /* ]]>
                */ </script> <noscript> Please
                <a href="http://enable-javascript.com">enable JavaScript</a>. </noscript> </div> "
            },
            "Locale":"sv-SE",
            "Currency":null,
            "CountryCode":null,
            "PresetValues":null,
            "OrderId":13,
            "Status":"Created"
        }
JSON;

        $this->apiResponse = 'HTTP/1.1 201 Created' . PHP_EOL;
        $this->apiResponse .= 'Cache-Control: no-cache' . PHP_EOL;
        $this->apiResponse .= 'Pragma: no-cache' . PHP_EOL;
        $this->apiResponse .= 'Content-Length: 3469' . PHP_EOL;
        $this->apiResponse .= 'Content-Type: application/json; charset=utf-8' . PHP_EOL;
        $this->apiResponse .= 'Expires: -1' . PHP_EOL;
        $this->apiResponse .= 'Server: Microsoft-IIS/8.5' . PHP_EOL;
        $this->apiResponse .= 'X-AspNet-Version: 4.0.30319' . PHP_EOL;
        $this->apiResponse .= 'X-Powered-By: ASP.NET' . PHP_EOL;
        $this->apiResponse .= 'Date: Wed, 27 Apr 2016 09:42:19 GMT';

        $this->apiResponse .= PHP_EOL . PHP_EOL . $json;
    }

    private function setInputData()
    {
        $this->inputData = array(
            "purchase_country" => "SE",
            "purchase_currency" => "SEK",
            "locale" => "sv-SE",
            "order_amount" => 10000,
            "order_tax_amount" => 2000,
            "order_lines" => array(
                array(
                    "articlenumber" => "123456789",
                    "name" => "Dator",
                    "quantity" => 200,
                    "unitprice" => 12300,
                    "discountpercent" => 1000,
                    "vatpercent" => 2500
                )
            ),
            "merchant_urls" => array(
                "terms" => "http://localhost:51898/terms",
                "checkout" => "http://localhost:51925/",
                "confirmation" => "http://localhost:51925/checkout/confirm",
                "push" => "https://svea.com/push.aspx?sid=123&svea_order=123"
            )
        );
    }

    private function setCheckoutData()
    {
        $this->checkoutData = new CheckoutData();

        $merchantData = $this->inputData['merchant_urls'];
        $merchantSettings = new MerchantSettings();
        $merchantSettings->setTermsUri($merchantData['terms']);
        $merchantSettings->setCheckoutUri($merchantData['checkout']);
        $merchantSettings->setConfirmationUri($merchantData['confirmation']);
        $merchantSettings->setPushUri($merchantData['push']);

        $this->checkoutData->setMerchantSettings($merchantSettings);

        $cart = new Cart();

        $orderLines = $this->inputData['order_lines'];
        foreach ($orderLines as $orderLine) {
            $orderRow = new OrderRow();
            $orderRow->setArticleNumber($orderLine['articlenumber']);
            $orderRow->setDiscountPercent($orderLine['discountpercent']);
            $orderRow->setName($orderLine['name']);
            $orderRow->setQuantity($orderLine['quantity']);
            $orderRow->setUnitPrice($orderLine['unitprice']);
            $orderRow->setVatPercent($orderLine['vatpercent']);

            $cart->addItem($orderRow);
        }

        $this->checkoutData->setCart($cart);

        $this->checkoutData->setLocale($this->inputData['locale']);

        $this->checkoutData->setCurrency($this->inputData['purchase_currency']);

        $this->checkoutData->setCountryCode($this->inputData['purchase_country']);
    }
}
