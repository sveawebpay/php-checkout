<?php


namespace Svea\Checkout\Tests\Unit\Transport;

use \Exception;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\Exception\SveaApiException;

class ConnectorTest extends TestCase
{
    public function testCreateMatchesDataGiven()
    {
        Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);

        $this->assertInstanceOf('\Svea\Checkout\Transport\ApiClient', $this->connector->getClient());
        $this->assertEquals($this->merchantId, $this->connector->getMerchantId());
        $this->assertEquals($this->sharedSecret, $this->connector->getSharedSecret());
        $this->assertEquals($this->apiUrl, $this->connector->getApiUrl());
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaConnectorException
     * @expectedExceptionMessage Merchant Id is missing
     */
    public function testCreateMissingMerchantId()
    {
        $this->merchantId = '';
        Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaConnectorException
     * @expectedExceptionMessage Shared secret is missing
     */
    public function testCreateMissingSharedSecret()
    {
        $this->sharedSecret = '';
        Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaConnectorException
     * @expectedExceptionMessage API Url is missing
     */
    public function testCreateMissingApiUrlSecret()
    {
        $this->apiUrl = '';
        Connector::create($this->merchantId, $this->sharedSecret, $this->apiUrl);
    }

    public function testSendRequestAndReceiveResponse()
    {
        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->request))
            ->will($this->returnValue('1'));

        $this->connector->setClient($this->apiClient);

        $this->assertEquals('1', $this->connector->send($this->request));
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage The input data was bad
     */
    public function testSendRequestSveaApiExceptionThrown()
    {
        $sveaApiException = new SveaApiException('The input data was bad', 1000);

        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->request))
            ->will($this->throwException($sveaApiException));

        $this->connector->setClient($this->apiClient);

        $this->connector->send($this->request);
    }

    /**
     * @expectedException \Svea\Checkout\Transport\Exception\SveaApiException
     * @expectedExceptionMessage API communication error
     */
    public function testSendRequestExceptionThrown()
    {
        $ex = new Exception('General error');

        $this->apiClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($this->request))
            ->will($this->throwException($ex));

        $this->connector->setClient($this->apiClient);

        $this->connector->send($this->request);
    }

    public function testCreateAuthorizationToken()
    {
        $expectedAuthToken = base64_encode($this->merchantId . ':' . hash('sha512', $this->request->getBody() . $this->sharedSecret));

        $method = $this->getPrivateMethod('Svea\Checkout\Transport\Connector', 'createAuthorizationToken');
        $method->invokeArgs($this->connector, array($this->request));

        $this->assertEquals($expectedAuthToken, $this->request->getAuthorizationToken());
    }

    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new \ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
