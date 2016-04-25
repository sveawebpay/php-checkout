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
            ->will($this->returnValue(200));

        $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $this->apiClient->sendRequest($this->request);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $response);
        $this->assertEquals($this->jsonResponseContent, $response->getContent());
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
            ->will($this->returnValue(201));

        $this->setHttpClient();

        /**
         * @var ResponseHandler $response
         */
        $response = $this->apiClient->sendRequest($this->request);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $response);
        $this->assertEquals($this->jsonResponseContent, $response->getContent());
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 400
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
            ->will($this->returnValue(400));

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 404
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
            ->will($this->returnValue(404));

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 401
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
            ->will($this->returnValue(401));

        $this->setHttpClient();
        $this->apiClient->sendRequest($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 404
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
            ->will($this->returnValue(404));

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
        $this->httpClientMock->expects($this->once())
            ->method('getErrorNumber')
            ->will($this->returnValue(2));

        $this->setHttpClient();

        // Use GET method for request
        $this->request->setPostMethod();
        $this->apiClient->sendRequest($this->request);
    }
}
