<?php


namespace Svea\Checkout\Tests\Unit\Transport;


use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Transport\ApiClient;
use Svea\Checkout\Transport\ResponseHandler;

class ApiClientTest extends TestCase
{
    protected function setHttpClient()
    {
        $this->apiClient = new ApiClient($this->httpClientMock);
        $this->apiClient->setHttpClient($this->httpClientMock);
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

        $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $this->apiClient->sendRequest($this->request);

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

        $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $this->apiClient->sendRequest($this->request);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $response);
        $this->assertEquals($this->responseContent, $response->getContent());
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage The input data was bad
     */
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

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage No order with requested ID was found.
     */
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

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage Unauthorized: Missing or incorrect Authorization token in header.
     */
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

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage Undefined error.
     */
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

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Could not resolve host: rarafsafsafasfas.com
     */
    public function testSendRequestWithHttpClientError()
    {
        $this->httpClientMock->expects($this->once())
            ->method('getError')
            ->will($this->returnValue('Could not resolve host: rarafsafsafasfas.com'));

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }
}
