<?php

namespace Svea\Checkout\Callback;

/**
 * Verifies HMAC signatures sent with Svea Checkout callbacks.
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
     * @param string $sharedSecret Checkout secret
     * @return bool
     */
    public function verify($payload, $signature, $timestamp, $sharedSecret)
    {
        if ($payload === null || $signature === null || $timestamp === null || $sharedSecret === null) {
            return false;
        }

        $signature = trim($signature);
        $timestampString = trim((string) $timestamp);

        if ($signature === '' || $timestampString === '' || $sharedSecret === '') {
            return false;
        }

        if (!$this->isTimestampValid($timestampString)) {
            return false;
        }

        $expectedSignature = $this->createSignature($payload, $timestampString, $sharedSecret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Create the expected HMAC signature for a callback payload.
     *
     * @param string $payload Raw request body
     * @param string|int $timestamp Header value from X-Timestamp
     * @param string $sharedSecret Checkout secret
     * @return string
     */
    public function createSignature($payload, $timestamp, $sharedSecret)
    {
        $message = $timestamp . '.' . $payload;

        return base64_encode(hash_hmac('sha512', $message, $sharedSecret, true));
    }

    /**
     * Validate that the timestamp is numeric and recent enough.
     *
     * @param string $timestamp
     * @return bool
     */
    private function isTimestampValid($timestamp)
    {
        return abs(time() - (int) $timestamp) <= self::MAX_TIMESTAMP_AGE_SECONDS;
    }
}
