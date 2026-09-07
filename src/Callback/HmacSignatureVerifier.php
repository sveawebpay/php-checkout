<?php

namespace Svea\Checkout\Callback;

/**
 * Verifies HMAC signatures sent for callback subscriptions.
 */
class HmacSignatureVerifier
{
    /**
     * Maximum allowed age difference for callback timestamps.
     *
     * @var int
     */
    private const MAX_TIMESTAMP_AGE_SECONDS = 300;

    /**
     * Verify a callback payload against the X-Signature-512 and X-Timestamp headers.
     *
     * @param string $payload Raw request body
     * @param string $signature Header value from X-Signature-512
     * @param string|int $timestamp Header value from X-Timestamp
     * @param string $secret Shared secret
     * @return bool
     */
    public function verify($payload, $signature, $timestamp, $secret)
    {
        if (
            !is_string($payload)
            || !is_string($signature)
            || (!is_string($timestamp) && !is_int($timestamp))
            || !is_string($secret)
        ) {
            return false;
        }

        $signature = trim($signature);
        $timestampString = trim((string) $timestamp);

        if ($signature === '' || $timestampString === '' || $secret === '') {
            return false;
        }

        if (!$this->isTimestampValid($timestampString)) {
            return false;
        }

        $expectedSignature = $this->createSignature($payload, $timestampString, $secret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Create the expected HMAC signature for a callback payload.
     *
     * @param string $payload Raw request body
     * @param string|int $timestamp Header value from X-Timestamp
     * @param string $secret Shared secret
     * @return string
     */
    public function createSignature($payload, $timestamp, $secret)
    {
        $message = $timestamp . '.' . $payload;

        return base64_encode(hash_hmac('sha512', $message, $secret, true));
    }

    /**
     * Validate that the timestamp is numeric and recent enough.
     *
     * @param string $timestamp
     * @return bool
     */
    private function isTimestampValid($timestamp)
    {
        if (preg_match('/^\d+$/D', $timestamp) !== 1) {
            return false;
        }

        return abs(time() - (int) $timestamp) <= self::MAX_TIMESTAMP_AGE_SECONDS;
    }
}
