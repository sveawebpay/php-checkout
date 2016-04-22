<?php


namespace Unit\Transport;


use Svea\Checkout\Transport\ApiClient;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\Request;
use Svea\Checkout\Transport\ResponseHandler;

class ClientTest extends \PHPUnit_Framework_TestCase
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

    protected $request;
    protected $responseContent;
    protected $jsonResponseContent;
    protected $httpClientMock;

    protected function setUp()
    {
        $this->request = new Request();
        $this->request->setApiUrl($this->apiUrl);
        $this->request->setBody(json_encode($this->orderData));
        $this->request->setPostMethod();
        $this->request->setAuthorizationToken('123456789');

        $this->responseContent = array('data' => 'This is content');
        $this->jsonResponseContent = json_encode($this->responseContent);

        $this->httpClientMock = $this->getMockBuilder('Svea\Checkout\Transport\Http\HttpRequestInterface')->getMock();
    }

    protected function setHttpClient()
    {
        $client = new ApiClient($this->httpClientMock);
        $client->setHttpClient($this->httpClientMock);

        return $client;
    }

    public function testSendRequestWithOkStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(200));

        $client = $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $client->sendRequest($this->request);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $response);
        $this->assertEquals($this->responseContent, $response->getContent());
    }

    public function testSendRequestWithCreatedStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(201));

        $client = $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $client->sendRequest($this->request);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $response);
        $this->assertEquals($this->responseContent, $response->getContent());
    }

    public function testSendRequestWithBadRequestStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(400));

        $client = $this->setHttpClient();


        $this->setExpectedException('\Svea\Checkout\Transport\Exception\SveaApiException', 'The input data was bad');

        $client->sendRequest($this->request);
    }

    public function testSendRequestWithNotFoundStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(404));

        $client = $this->setHttpClient();


        $this->setExpectedException('\Svea\Checkout\Transport\Exception\SveaApiException', 'No order with requested ID was found.');

        $client->sendRequest($this->request);
    }

    public function testSendRequestWithUnauthorizedStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(401));

        $client = $this->setHttpClient();


        $this->setExpectedException('\Svea\Checkout\Transport\Exception\SveaApiException',
            'Unauthorized: Missing or incorrect Authorization token in header. ' .
            'Please verify that you used the correct Merchant ID and Shared secret when you constructed your client.');

        $client->sendRequest($this->request);
    }

    public function testSendRequestWithUndefinedStatusResponse()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue(''));
        $this->httpClientMock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->jsonResponseContent));
        $this->httpClientMock->expects($this->once())
            ->method('getInfo')
            ->with(CURLINFO_HTTP_CODE)
            ->will($this->returnValue(''));

        $client = $this->setHttpClient();


        $this->setExpectedException('\Svea\Checkout\Transport\Exception\SveaApiException', 'Undefined error.');

        $client->sendRequest($this->request);
    }

    public function testSendRequestWithHttpClientError()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue('Could not resolve host: rarafsafsafasfas.com'));

        $client = $this->setHttpClient();

        $this->setExpectedException('\Exception', 'Could not resolve host: rarafsafsafasfas.com');

        $client->sendRequest($this->request);
    }
}
