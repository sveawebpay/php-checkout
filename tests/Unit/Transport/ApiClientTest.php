<?php

namespace Svea\Checkout\Tests\Unit\Transport;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Transport\ApiClient;
use Svea\Checkout\Transport\ResponseHandler;
use Svea\Checkout\Version;

class ApiClientTest extends TestCase
{
    public function testSetDeleteMethod()
    {
        $this->requestModel->setDeleteMethod();

        $this->assertEquals(Request::METHOD_DELETE, $this->requestModel->getMethod());
        $this->assertNull($this->requestModel->getBody());
    }

    public function testDeleteUsesCustomRequestWithoutPostData()
    {
        $options = array();
        $this->httpClientMock->method('setOption')
            ->willReturnCallback(function ($name, $value) use (&$options) {
                $options[$name] = $value;
            });
        $this->mockHttpClient($this->apiResponse, 200);
        $this->requestModel->setDeleteMethod();

        $this->apiClientMock->sendRequest($this->requestModel);

        $this->assertEquals(Request::METHOD_DELETE, $options[CURLOPT_CUSTOMREQUEST]);
        $this->assertArrayNotHasKey(CURLOPT_POST, $options);
        $this->assertArrayNotHasKey(CURLOPT_POSTFIELDS, $options);
    }

    public function testDeleteRejectsBodySetAfterMethod()
    {
        $this->requestModel->setDeleteMethod();

        $this->expectException('\InvalidArgumentException');
        $this->requestModel->setBody('{}');
    }

    public function testSendRequestWithOkStatusResponse()
    {
        $httpCode = 200;
        $this->mockHttpClient($this->apiResponse, $httpCode);

        /**
         * @var ResponseHandler $responseHandler
         */
        $responseHandler = $this->apiClientMock->sendRequest($this->requestModel);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $responseHandler);
        $this->assertEquals($httpCode, $responseHandler->getHttpCode());
    }

    public function testSendRequestIncludesSdkPackageHeader()
    {
        $options = array();
        $this->httpClientMock->method('setOption')
            ->willReturnCallback(function ($name, $value) use (&$options) {
                $options[$name] = $value;
            });
        $this->mockHttpClient($this->apiResponse, 200);

        $this->apiClientMock->sendRequest($this->requestModel);

        $this->assertContains('X-SVEA-SDK-PACKAGE: PHP:' . Version::SDK, $options[CURLOPT_HTTPHEADER]);
    }

    public function testSendRequestWithCreatedStatusResponse()
    {
        $httpCode = 201;
        $this->mockHttpClient($this->apiResponse, $httpCode);

        /**
         * @var ResponseHandler $responseHandler
         */
        $responseHandler = $this->apiClientMock->sendRequest($this->requestModel);

        $this->assertInstanceOf('Svea\Checkout\Transport\ResponseHandler', $responseHandler);
        $this->assertEquals($httpCode, $responseHandler->getHttpCode());
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 400
     */
    public function testSendRequestWithBadRequestStatusResponse()
    {
        $this->mockHttpClient(null, 400);
        $this->requestModel->setPutMethod();

        $this->apiClientMock->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 404
     */
    public function testSendRequestWithNotFoundStatusResponse()
    {
        $this->mockHttpClient(null, 404);

        $this->apiClientMock->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 401
     */
    public function testSendRequestWithUnauthorizedStatusResponse()
    {
        $this->mockHttpClient(null, 401);

        $this->apiClientMock->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 404
     */
    public function testSendRequestWith404StatusResponse()
    {
        $this->mockHttpClient(null, 404);

        $this->apiClientMock->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage Specific error message
     * @expectedExceptionCode 2001
     */
    public function testSendRequestWithCustomErrorResponse()
    {
        $arrayData = array(
            "Code" => 2001,
            "Message" => "Global error message",
            "Errors" => array(
                array(
                    "Code" => 2002,
                    "ErrorMessage" => "Specific error message"
                )
            )
        );
        $apiResponse = 'HTTP/1.1 400 Bad request' . "\r\n";
        $apiResponse .= 'Cache-Control: no-cache' . "\r\n";
        $apiResponse .= 'Date: Wed, 27 Apr 2016 09:42:19 GMT';

        $apiResponse .= "\r\n\r\n" . json_encode($arrayData);
        $this->mockHttpClient($apiResponse, 404);

        $this->apiClientMock->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Could not resolve host: rarafsafsafasfas.com
     */
    public function testSendRequestWithHttpClientError()
    {
        $error = 'Could not resolve host: rarafsafsafasfas.com';
        $this->mockHttpClient(null, null, $error, 2);

        $this->requestModel->setGetMethod();
        $this->apiClientMock->sendRequest($this->requestModel);
    }

    private function mockHttpClient($executeValue, $infoValue, $errorValue = null, $errorNumber = null)
    {
        if ($executeValue !== null) {
            $this->httpClientMock->expects($this->once())
                ->method('execute')
                ->will($this->returnValue($executeValue));
        }
        if ($infoValue !== null) {
            $this->httpClientMock->expects($this->once())
                ->method('getInfo')
                ->will($this->returnValue($infoValue));
        }
        if ($errorValue !== null) {
            $this->httpClientMock->expects($this->once())
                ->method('getError')
                ->will($this->returnValue($errorValue));
        }
        if ($errorNumber !== null) {
            $this->httpClientMock->expects($this->once())
                ->method('getErrorNumber')
                ->will($this->returnValue($errorNumber));
        }

        $this->setHttpClient();
    }

    private function setHttpClient()
    {
        $this->apiClientMock = new ApiClient($this->httpClientMock);
    }
}
