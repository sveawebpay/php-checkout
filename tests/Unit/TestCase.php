<?php


namespace Svea\Checkout\Tests\Unit;


use Svea\Checkout\Transport\ApiClient;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\Http\HttpRequestInterface;
use Svea\Checkout\Transport\Request;
use Svea\Checkout\Transport\ResponseHandler;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseHandler $response
     */
    protected $response;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var Connector $connector
     */
    protected $connector;

    /**
     * @var ApiClient $apiClient
     */
    protected $apiClient;

    /**
     * @var HttpRequestInterface $httpClientMock
     */
    protected $httpClientMock;

    // Response
    protected $responseContent;
    protected $jsonResponseContent;

    // Client Credentials
    protected $merchantId = '123456';
    protected $sharedSecret = '80e3a905e597ca428f4e25200433263c';
    protected $apiUrl = Connector::TEST_BASE_URL;

    // Request body data - Mock
    protected $orderData = array(
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

    protected function setUp()
    {
        $this->responseContent = array(
            'data' => 'This is content',
            'Message' => 'Error message'
        );
        $this->jsonResponseContent = json_encode($this->responseContent);

        $this->setRequest();
        $this->setCurlRequest();
        $this->setApiClient();
        $this->setConnector();
    }

    private function setRequest()
    {
        $this->request = new Request();
        $this->request->setApiUrl($this->apiUrl);
        $this->request->setBody(json_encode($this->orderData));
        $this->request->setPostMethod();
        $this->request->setAuthorizationToken('123456789');
    }

    private function setCurlRequest()
    {
        $this->httpClientMock = $this->getMockBuilder('Svea\Checkout\Transport\Http\HttpRequestInterface')->getMock();
    }

    private function setApiClient()
    {
        $httpClientMock = $this->getMockBuilder('Svea\Checkout\Transport\Http\HttpRequestInterface')->getMock();
        $this->apiClient = $this->getMockBuilder('\Svea\Checkout\Transport\ApiClient')
            ->setConstructorArgs(array($httpClientMock))
            ->getMock();
    }

    private function setConnector()
    {
        $this->connector = Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }
}
