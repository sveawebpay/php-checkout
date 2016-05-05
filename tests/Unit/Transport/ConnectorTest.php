<?php

namespace Svea\Checkout\Tests\Unit\Transport;

use \Exception;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Exception\SveaApiException;

class ConnectorTest extends TestCase
{
    public function testCreateMatchesDataGiven()
    {
        $this->connectorMock = new Connector(
            $this->apiClientMock,
            $this->merchantId,
            $this->sharedSecret,
            $this->apiUrl
        );

        $this->assertInstanceOf('\Svea\Checkout\Transport\ApiClient', $this->connectorMock->getApiClient());
        $this->assertEquals($this->merchantId, $this->connectorMock->getMerchantId());
        $this->assertEquals($this->sharedSecret, $this->connectorMock->getSharedSecret());
        $this->assertEquals($this->apiUrl, $this->connectorMock->getApiUrl());
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_MERCHANT_ID
     */
    public function testCreateMissingMerchantId()
    {
        $this->merchantId = '';
        new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_SHARED_SECRET
     */
    public function testCreateMissingSharedSecret()
    {
        $this->sharedSecret = '';
        new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_API_BASE_URL
     */
    public function testCreateMissingApiUrlSecret()
    {
        $this->apiUrl = '';
        new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INCORRECT_API_BASE_URL
     */
    public function testCreateBadApiUrlSecret()
    {
        $this->apiUrl = 'http://svea.com';
        new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    public function testSendRequestAndReceiveResponse()
    {
        $content = $this->apiResponse;
        $httpCode = 201;
        $responseHandler = $this->getMockBuilder('\Svea\Checkout\Transport\ResponseHandler')
            ->setConstructorArgs(array($content, $httpCode))
            ->getMock();

        $responseHandler->expects($this->once())
            ->method('getContent');

        $this->apiClientMock->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($responseHandler));

        $connector = new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage The input data was bad
     */
    public function testSendRequestSveaApiExceptionThrown()
    {
        $sveaApiException = new SveaApiException('The input data was bad', 1000);

        $this->apiClientMock->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->requestModel))
            ->will($this->throwException($sveaApiException));

        $connector = new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->sendRequest($this->requestModel);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage API communication error
     */
    public function testSendRequestExceptionThrown()
    {
        $ex = new Exception('General error');

        $this->apiClientMock->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->requestModel))
            ->will($this->throwException($ex));

        $connector = new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->sendRequest($this->requestModel);
    }

    public function testCreateAuthorizationToken()
    {
        $expectedAuthToken = base64_encode(
            $this->merchantId .
            ':' .
            hash(
                'sha512',
                $this->requestModel->getBody() .
                $this->sharedSecret
            )
        );

        $connector = new Connector($this->apiClientMock, $this->merchantId, $this->sharedSecret, $this->apiUrl);
        $this->invokeMethod($connector, 'createAuthorizationToken', array($this->requestModel));

        $this->assertEquals($expectedAuthToken, $this->requestModel->getAuthorizationToken());
    }
}
