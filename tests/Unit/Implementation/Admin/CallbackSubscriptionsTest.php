<?php

namespace Svea\Checkout\Tests\Unit\Implementation\Admin;

use Svea\Checkout\Implementation\Admin\AddCallbackSubscription;
use Svea\Checkout\Implementation\Admin\GetCallbackSubscription;
use Svea\Checkout\Implementation\Admin\GetCallbackSubscriptions;
use Svea\Checkout\Implementation\Admin\RemoveCallbackSubscription;
use Svea\Checkout\Implementation\Admin\UpdateCallbackSubscription;
use Svea\Checkout\Implementation\Admin\VerifyCallbackSubscription;
use Svea\Checkout\Model\Request;
use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Transport\Connector;

class CallbackSubscriptionsTest extends TestCase
{
    /**
     * @var \Svea\Checkout\Validation\ValidationService|\PHPUnit\Framework\MockObject\MockObject
     */
    private $validatorMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->validatorMock = $this->getMockBuilder('\Svea\Checkout\Validation\ValidationService')->getMock();
        $this->connectorMock->method('getBaseApiUrl')->willReturn(Connector::TEST_ADMIN_BASE_URL);
    }

    public function testPrepareListRequest()
    {
        $implementation = new GetCallbackSubscriptions($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array());

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_GET, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions/',
            $request->getApiUrl()
        );
        $this->assertNull($request->getBody());
    }

    public function testPrepareGetRequest()
    {
        $id = 'df7fd762-83ac-491a-3bb0-08dedc32520c';
        $implementation = new GetCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array('subscriptionid' => $id));

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_GET, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions/' . $id,
            $request->getApiUrl()
        );
        $this->assertNull($request->getBody());
    }

    public function testPrepareAddRequestOmitsSecretWhenNotSupplied()
    {
        $data = array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        );
        $implementation = new AddCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData($data);

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_POST, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions',
            $request->getApiUrl()
        );
        $this->assertEquals(
            '{"CallbackUri":"https:\/\/merchant.example\/callback","Events":["CheckoutOrder.Created"]}',
            $request->getBody()
        );
    }

    public function testPrepareAddRequestIncludesSuppliedSecret()
    {
        $implementation = new AddCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created'),
            'secret' => 'callback-secret'
        ));

        $this->assertEquals(
            array(
                'CallbackUri' => 'https://merchant.example/callback',
                'Events' => array('CheckoutOrder.Created'),
                'Secret' => 'callback-secret'
            ),
            json_decode($implementation->getRequestModel()->getBody(), true)
        );
    }

    public function testPrepareAddRequestSerializesSparseEventsAsAJsonList()
    {
        $implementation = new AddCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array(
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array(2 => 'CheckoutOrder.Created')
        ));

        $this->assertEquals(
            array('CheckoutOrder.Created'),
            json_decode($implementation->getRequestModel()->getBody(), true)['Events']
        );
    }

    public function testPrepareUpdateRequestIncludesSuppliedEmptySecret()
    {
        $id = 'df7fd762-83ac-491a-3bb0-08dedc32520c';
        $data = array(
            'subscriptionid' => $id,
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created'),
            'secret' => ''
        );
        $implementation = new UpdateCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData($data);

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_PUT, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions/' . $id,
            $request->getApiUrl()
        );
        $this->assertEquals(
            '{"CallbackUri":"https:\/\/merchant.example\/callback","Events":["CheckoutOrder.Created"],"Secret":""}',
            $request->getBody()
        );
        $this->assertArrayNotHasKey('SubscriptionId', json_decode($request->getBody(), true));
    }

    public function testPrepareUpdateRequestOmitsSecretWhenNotSupplied()
    {
        $data = array(
            'subscriptionid' => 'df7fd762-83ac-491a-3bb0-08dedc32520c',
            'callbackuri' => 'https://merchant.example/callback',
            'events' => array('CheckoutOrder.Created')
        );
        $implementation = new UpdateCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData($data);

        $requestData = json_decode($implementation->getRequestModel()->getBody(), true);
        $this->assertArrayNotHasKey('Secret', $requestData);
        $this->assertArrayNotHasKey('SubscriptionId', $requestData);
    }

    public function testPrepareVerifyRequest()
    {
        $id = 'df7fd762-83ac-491a-3bb0-08dedc32520c';
        $implementation = new VerifyCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array('subscriptionid' => $id));

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_POST, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions/' . $id . '/verify',
            $request->getApiUrl()
        );
        $this->assertNull($request->getBody());
    }

    public function testPrepareRemoveRequest()
    {
        $id = 'df7fd762-83ac-491a-3bb0-08dedc32520c';
        $implementation = new RemoveCallbackSubscription($this->connectorMock, $this->validatorMock);
        $implementation->prepareData(array('subscriptionid' => $id));

        $request = $implementation->getRequestModel();
        $this->assertEquals(Request::METHOD_DELETE, $request->getMethod());
        $this->assertEquals(
            Connector::TEST_ADMIN_BASE_URL . '/api/v2/callbacks/subscriptions/' . $id,
            $request->getApiUrl()
        );
        $this->assertNull($request->getBody());
    }

    public function testEveryImplementationInvokesConnector()
    {
        $implementations = array(
            new GetCallbackSubscriptions($this->connectorMock, $this->validatorMock),
            new GetCallbackSubscription($this->connectorMock, $this->validatorMock),
            new AddCallbackSubscription($this->connectorMock, $this->validatorMock),
            new UpdateCallbackSubscription($this->connectorMock, $this->validatorMock),
            new VerifyCallbackSubscription($this->connectorMock, $this->validatorMock),
            new RemoveCallbackSubscription($this->connectorMock, $this->validatorMock)
        );
        $this->connectorMock->expects($this->exactly(6))
            ->method('sendRequest')
            ->willReturn('response');

        foreach ($implementations as $implementation) {
            $implementation->setRequestModel($this->requestModel);
            $implementation->invoke();
            $this->assertEquals('response', $implementation->getResponseHandler());
        }
    }

    public function testEveryImplementationDelegatesValidation()
    {
        $implementations = array(
            new GetCallbackSubscriptions($this->connectorMock, $this->validatorMock),
            new GetCallbackSubscription($this->connectorMock, $this->validatorMock),
            new AddCallbackSubscription($this->connectorMock, $this->validatorMock),
            new UpdateCallbackSubscription($this->connectorMock, $this->validatorMock),
            new VerifyCallbackSubscription($this->connectorMock, $this->validatorMock),
            new RemoveCallbackSubscription($this->connectorMock, $this->validatorMock)
        );
        $this->validatorMock->expects($this->exactly(6))->method('validate');

        foreach ($implementations as $implementation) {
            $implementation->validateData(array());
        }
    }
}
