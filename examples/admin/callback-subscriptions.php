<?php
/**
 * Manage Payment Admin callback subscriptions.
 *
 * If you use Composer, require ../../vendor/autoload.php instead.
 */
require_once '../../include.php';

$merchantId = getenv('SVEA_MERCHANT_ID');
$merchantApiSecret = getenv('SVEA_MERCHANT_API_SECRET');
$secret = getenv('SVEA_CALLBACK_SECRET');
$callbackUri = getenv('SVEA_CALLBACK_URI');

if (!$merchantId || !$merchantApiSecret || !$secret || !$callbackUri) {
    throw new RuntimeException(
        'Set the SVEA merchant, API secret, callback secret, and callback URI environment variables.'
    );
}

$connector = \Svea\Checkout\Transport\Connector::init(
    $merchantId,
    $merchantApiSecret,
    \Svea\Checkout\Transport\Connector::TEST_ADMIN_BASE_URL
);
$client = new \Svea\Checkout\CheckoutAdminClient($connector);

$subscriptions = $client->getCallbackSubscriptions();

$created = $client->addCallbackSubscription(array(
    'CallbackUri' => $callbackUri,
    'Events' => array(
        'CheckoutOrder.Created',
        'CheckoutOrder.PendingStatusReleased'
    ),
    'Secret' => $secret
));

$subscriptionId = $created['SubscriptionId'];
$subscription = $client->getCallbackSubscription(array(
    'SubscriptionId' => $subscriptionId
));

$updated = $client->updateCallbackSubscription(array(
    'SubscriptionId' => $subscriptionId,
    'CallbackUri' => $callbackUri,
    'Events' => array('CheckoutOrder.Created'),
    'Secret' => $secret
));

$verified = $client->verifyCallbackSubscription(array(
    'SubscriptionId' => $subscriptionId
));

// Explicit cleanup: uncomment only when this subscription should be deleted.
// $removed = $client->removeCallbackSubscription(array('SubscriptionId' => $subscriptionId));
