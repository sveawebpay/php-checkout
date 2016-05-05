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
        $this->connector = new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $this->assertInstanceOf('\Svea\Checkout\Transport\ApiClient', $this->connector->getClient());
        $this->assertEquals($this->merchantId, $this->connector->getMerchantId());
        $this->assertEquals($this->sharedSecret, $this->connector->getSharedSecret());
        $this->assertEquals($this->apiUrl, $this->connector->getApiUrl());
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_MERCHANT_ID
     */
    public function testCreateMissingMerchantId()
    {
        $this->merchantId = '';
        new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_SHARED_SECRET
     */
    public function testCreateMissingSharedSecret()
    {
        $this->sharedSecret = '';
        new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::MISSING_API_BASE_URL
     */
    public function testCreateMissingApiUrlSecret()
    {
        $this->apiUrl = '';
        new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaConnectorException
     * @expectedExceptionCode Svea\Checkout\Exception\ExceptionCodeList::INCORRECT_API_BASE_URL
     */
    public function testCreateBadApiUrlSecret()
    {
        $this->apiUrl = 'http://svea.com';
        new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
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

        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($responseHandler));

        $connector = new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->setClient($this->apiClient);
        $connector->sendRequest($this->requestHandler);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage The input data was bad
     */
    public function testSendRequestSveaApiExceptionThrown()
    {
        $sveaApiException = new SveaApiException('The input data was bad', 1000);

        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->requestHandler))
            ->will($this->throwException($sveaApiException));

        $connector = new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->setClient($this->apiClient);
        $connector->sendRequest($this->requestHandler);
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage API communication error
     */
    public function testSendRequestExceptionThrown()
    {
        $ex = new Exception('General error');

        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->requestHandler))
            ->will($this->throwException($ex));

        $connector = new Connector($this->merchantId, $this->sharedSecret, $this->apiUrl);
        $connector->setClient($this->apiClient);
        $connector->sendRequest($this->requestHandler);
    }

    public function testCreateAuthorizationToken()
    {
        $expectedAuthToken = base64_encode(
            $this->merchantId .
            ':' .
            hash(
                'sha512',
                $this->requestHandler->getBody() .
                $this->sharedSecret
            )
        );

        $method = $this->getPrivateMethod('Svea\Checkout\Transport\Connector', 'createAuthorizationToken');
        $method->invokeArgs($this->connector, array($this->requestHandler));

        $this->assertEquals($expectedAuthToken, $this->requestHandler->getAuthorizationToken());
    }

    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new \ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
