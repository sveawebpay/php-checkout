<?php

namespace Svea\Checkout\Tests\Unit;

use Svea\Checkout\CheckoutAdminClient;
use Svea\Checkout\Transport\Connector;
use Svea\Checkout\Transport\ResponseHandler;

class CheckoutAdminClientTest extends TestCase
{
    public function testCallbackSubscriptionMethodsUseTheImplementationPipeline()
    {
        $responseHandler = new ResponseHandler('HTTP/1.1 200 OK' . "\r\n\r\n" . '{"ok":true}', 200);
        $this->connectorMock->method('getBaseApiUrl')->willReturn(Connector::TEST_ADMIN_BASE_URL);
        $this->connectorMock->expects($this->exactly(6))
            ->method('sendRequest')
            ->willReturn($responseHandler);
        $client = new CheckoutAdminClient($this->connectorMock);
        $id = 'df7fd762-83ac-491a-3bb0-08dedc32520c';
        $subscription = array('SubscriptionId' => $id);
        $payload = array(
            'CallbackUri' => 'https://merchant.example/callback',
            'Events' => array('CheckoutOrder.Created'),
            'Secret' => 'callback-secret'
        );

        $responses = array(
            $client->getCallbackSubscriptions(),
            $client->getCallbackSubscription($subscription),
            $client->addCallbackSubscription($payload),
            $client->updateCallbackSubscription(array_merge($subscription, $payload)),
            $client->verifyCallbackSubscription($subscription),
            $client->removeCallbackSubscription($subscription)
        );

        foreach ($responses as $response) {
            $this->assertEquals(array('ok' => true), $response);
        }
    }
}
