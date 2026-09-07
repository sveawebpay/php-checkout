<?php

namespace Svea\Checkout\Tests\Unit\Callback;

use Svea\Checkout\Callback\HmacSignatureVerifier;
use Svea\Checkout\Tests\Unit\TestCase;

class HmacSignatureVerifierTest extends TestCase
{
    /**
     * @var HmacSignatureVerifier
     */
    private $verifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->verifier = new HmacSignatureVerifier();
    }

    public function testCreateSignatureMatchesDocumentedValue()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = '1713001200';
        $secret = 'secret';

        $expectedSignature = 'NOiNgMpRxhY6+oWj7Lo6Mrtnl/1sGFSbLLTc6QqjA4D4ZUbtvX8wHZaNIzCgGe9Tm6YmhuqxN1CqlcX94fMMWg==';

        $this->assertEquals(
            $expectedSignature,
            $this->verifier->createSignature($payload, $timestamp, $secret)
        );
    }

    public function testVerifyReturnsTrueForValidSignature()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $secret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $secret);

        $this->assertTrue($this->verifier->verify($payload, $signature, $timestamp, $secret));
    }

    public function testVerifyReturnsFalseForChangedSignatureCase()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $secret = 'secret';
        $signature = strtoupper($this->verifier->createSignature($payload, $timestamp, $secret));

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, $secret));
    }

    public function testVerifyReturnsFalseForChangedPayload()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $secret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $secret);

        $this->assertFalse(
            $this->verifier->verify('{"orderId":124,"status":"confirmed"}', $signature, $timestamp, $secret)
        );
    }

    public function testVerifyReturnsFalseForChangedTimestamp()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $secret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $secret);

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp + 1, $secret));
    }

    public function testVerifyReturnsFalseForMissingHeaders()
    {
        $this->assertFalse($this->verifier->verify(null, 'signature', time(), 'secret'));
        $this->assertFalse($this->verifier->verify('{}', null, time(), 'secret'));
        $this->assertFalse($this->verifier->verify('{}', 'signature', null, 'secret'));
        $this->assertFalse($this->verifier->verify('{}', 'signature', time(), null));
    }

    public function testVerifyReturnsFalseForStaleTimestamp()
    {
        $payload = '{}';
        $timestamp = time() - 301;
        $signature = $this->verifier->createSignature($payload, $timestamp, 'secret');

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, 'secret'));
    }

    public function testVerifyReturnsFalseForFutureTimestamp()
    {
        $payload = '{}';
        $timestamp = time() + 301;
        $signature = $this->verifier->createSignature($payload, $timestamp, 'secret');

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, 'secret'));
    }

    public function testVerifyReturnsFalseForNonNumericTimestamp()
    {
        $payload = '{}';
        $timestamp = time() . 'invalid';
        $signature = $this->verifier->createSignature($payload, $timestamp, 'secret');

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, 'secret'));
    }

    public function testVerifyReturnsFalseForEmptyCallbackSecret()
    {
        $payload = '{}';
        $timestamp = time();
        $signature = $this->verifier->createSignature($payload, $timestamp, '');

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, ''));
    }

    public function testVerifyReturnsFalseForNonStringCallbackSecret()
    {
        $payload = '{}';
        $timestamp = time();
        $signature = $this->verifier->createSignature($payload, $timestamp, '');

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, false));
    }
}
