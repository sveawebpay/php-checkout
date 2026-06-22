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

    public function testCreateSignature()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = '1713001200';
        $sharedSecret = 'secret';

        $expectedSignature = 'NOiNgMpRxhY6+oWj7Lo6Mrtnl/1sGFSbLLTc6QqjA4D4ZUbtvX8wHZaNIzCgGe9Tm6YmhuqxN1CqlcX94fMMWg==';

        $this->assertEquals(
            $expectedSignature,
            $this->verifier->createSignature($payload, $timestamp, $sharedSecret)
        );
    }

    public function testVerifyReturnsTrueForValidSignature()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $sharedSecret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $sharedSecret);

        $this->assertTrue($this->verifier->verify($payload, $signature, $timestamp, $sharedSecret));
    }

    public function testVerifyReturnsFalseForChangedSignatureCase()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $sharedSecret = 'secret';
        $signature = strtoupper($this->verifier->createSignature($payload, $timestamp, $sharedSecret));

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp, $sharedSecret));
    }

    public function testVerifyReturnsFalseForChangedPayload()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $sharedSecret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $sharedSecret);

        $this->assertFalse(
            $this->verifier->verify('{"orderId":124,"status":"confirmed"}', $signature, $timestamp, $sharedSecret)
        );
    }

    public function testVerifyReturnsFalseForChangedTimestamp()
    {
        $payload = '{"orderId":123,"status":"confirmed"}';
        $timestamp = time();
        $sharedSecret = 'secret';
        $signature = $this->verifier->createSignature($payload, $timestamp, $sharedSecret);

        $this->assertFalse($this->verifier->verify($payload, $signature, $timestamp + 1, $sharedSecret));
    }

    public function testVerifyReturnsFalseForMissingHeaders()
    {
        $this->assertFalse($this->verifier->verify('{}', null, time(), 'secret'));
        $this->assertFalse($this->verifier->verify('{}', 'signature', null, 'secret'));
        $this->assertFalse($this->verifier->verify('{}', 'signature', time(), null));
    }
}
