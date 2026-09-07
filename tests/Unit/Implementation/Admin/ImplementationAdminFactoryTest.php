<?php

namespace Svea\Checkout\Tests\Unit\Implementation\Admin;

use Svea\Checkout\Implementation\Admin\ImplementationAdminFactory;
use Svea\Checkout\Tests\Unit\TestCase;

class ImplementationAdminFactoryTest extends TestCase
{
    public function testReturnsCallbackSubscriptionImplementations()
    {
        $implementations = array(
            'GetCallbackSubscriptions' => ImplementationAdminFactory::returnGetCallbackSubscriptionsClass(
                $this->connectorMock
            ),
            'GetCallbackSubscription' => ImplementationAdminFactory::returnGetCallbackSubscriptionClass(
                $this->connectorMock
            ),
            'AddCallbackSubscription' => ImplementationAdminFactory::returnAddCallbackSubscriptionClass(
                $this->connectorMock
            ),
            'UpdateCallbackSubscription' => ImplementationAdminFactory::returnUpdateCallbackSubscriptionClass(
                $this->connectorMock
            ),
            'VerifyCallbackSubscription' => ImplementationAdminFactory::returnVerifyCallbackSubscriptionClass(
                $this->connectorMock
            ),
            'RemoveCallbackSubscription' => ImplementationAdminFactory::returnRemoveCallbackSubscriptionClass(
                $this->connectorMock
            )
        );

        foreach ($implementations as $class => $implementation) {
            $this->assertInstanceOf('Svea\\Checkout\\Implementation\\Admin\\' . $class, $implementation);
        }
    }
}
