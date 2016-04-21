<?php


namespace Unit\Transport;

use \Exception;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\Exception\SveaApiException;
use Svea\Checkout\Transport\Request;

class ConnectorTest extends \PHPUnit_Framework_TestCase
{
    private $merchantId = '123456';
    private $sharedSecret = '80e3a905e597ca428f4e25200433263c';
    private $apiUrl = Connector::TEST_BASE_URL;
    private $orderData = array(
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

    public function testCreateMatchesDataGiven()
    {
        $connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $this->assertInstanceOf('Svea\Checkout\Transport\Client', $connector->getClient());
        $this->assertEquals($this->merchantId, $connector->getMerchantId());
        $this->assertEquals($this->sharedSecret, $connector->getSharedSecret());
        $this->assertEquals($this->apiUrl, $connector->getApiUrl());
    }

    public function testCreateMissingMerchantId()
    {
        $this->setExpectedException('Svea\Checkout\Transport\Exception\SveaConnectorException',
            'Merchant Id is missing');

        Connector::create('', $this->sharedSecret, $this->apiUrl);
    }

    public function testCreateMissingSharedSecret()
    {
        $this->setExpectedException('Svea\Checkout\Transport\Exception\SveaConnectorException',
            'Shared secret is missing');

        Connector::create($this->merchantId, '', $this->apiUrl);
    }

    public function testCreateMissingApiUrlSecret()
    {
        $this->setExpectedException('Svea\Checkout\Transport\Exception\SveaConnectorException',
            'API Url is missing');

        Connector::create($this->merchantId, $this->sharedSecret, '');
    }

    public function testSendRequestAndReceiveResponse()
    {
        $request = new Request();
        $request->setApiUrl($this->apiUrl);
        $request->setBody(json_encode($this->orderData));

        $connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $apiClient = $this->getMockBuilder('Svea\Checkout\Transport\Client')->getMock();
        $apiClient->expects($this->once())
            ->method('request')
            ->with($this->identicalTo($request))
            ->will($this->returnValue('1'));

        $connector->setClient($apiClient);

        $this->assertEquals('1', $connector->send($request));
    }

    public function testSendRequestSveaApiExceptionThrown()
    {
        $request = new Request();
        $request->setApiUrl($this->apiUrl);
        $request->setBody(json_encode($this->orderData));

        $connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $sveaApiException = new SveaApiException('The input data was bad', 1000);

        $apiClient = $this->getMockBuilder('Svea\Checkout\Transport\Client')->getMock();
        $apiClient->expects($this->once())
            ->method('request')
            ->with($this->identicalTo($request))
            ->will($this->throwException($sveaApiException));

        $connector->setClient($apiClient);

        $this->setExpectedException('Svea\Checkout\Transport\Exception\SveaApiException',
            'The input data was bad');

        $connector->send($request);
    }

    public function testSendRequestExceptionThrown()
    {
        $request = new Request();
        $request->setApiUrl($this->apiUrl);
        $request->setBody(json_encode($this->orderData));

        $connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $ex = new Exception('General error');

        $apiClient = $this->getMockBuilder('Svea\Checkout\Transport\Client')->getMock();
        $apiClient->expects($this->once())
            ->method('request')
            ->with($this->identicalTo($request))
            ->will($this->throwException($ex));

        $connector->setClient($apiClient);

        $this->setExpectedException('\Svea\Checkout\Transport\Exception\SveaApiException', 'API communication error');

        $connector->send($request);
    }

    public function testCreateAuthorizationToken()
    {
        $request = new Request();
        $request->setApiUrl($this->apiUrl);
        $request->setBody(json_encode($this->orderData));

        $connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);
        $expectedAuthToken = base64_encode($this->merchantId . ':' . hash('sha512', $request->getBody() . $this->sharedSecret));

        $method = $this->getPrivateMethod('Svea\Checkout\Transport\Connector', 'createAuthorizationToken');
        $method->invokeArgs($connector, array($request));

        $this->assertEquals($expectedAuthToken, $request->getAuthorizationToken());
    }

    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new \ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
