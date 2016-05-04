<?php

namespace Svea\Checkout\Tests\Unit\Transport;

use Svea\Checkout\Tests\Unit\TestCase;
use Svea\Checkout\Transport\ResponseHandler;

class ResponseHandlerTest extends TestCase
{
    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionCode 401
     */
    public function testHandleClientResponseExceptionThrown()
    {
        $body = '';
        $content = 'HTTP/1.1 401 Unauthorized' . PHP_EOL . PHP_EOL . $body;
        $httpCode = 401;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->handleClientResponse();
    }

    public function testHandleClientResponseWithSuccessfulResponse()
    {
        $body = '{"test":"Order create successful"}';
        $content = 'HTTP/1.1 201 Created' . PHP_EOL . PHP_EOL . $body;
        $httpCode = 201;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->handleClientResponse();

        $this->assertEquals(json_decode($body, true), $responseHandler->getContent());
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage Bad request message
     */
    public function testThrowErrorWithErrorMessageFromApiResponse()
    {
        $body = '';
        $content = 'HTTP/1.1 400 Bad request' . PHP_EOL;
        $content .= 'ErrorMessage: Bad request message';
        $content .= PHP_EOL . PHP_EOL . $body;
        $httpCode = 400;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->throwError();
    }

    /**
     * @expectedException \Svea\Checkout\Exception\SveaApiException
     * @expectedExceptionMessage HTTP/1.1 401 Unauthorized
     */
    public function testThrowErrorWithGeneralResponseMessage()
    {
        $body = '';
        $content = 'HTTP/1.1 401 Unauthorized' . PHP_EOL . PHP_EOL . $body;
        $httpCode = 401;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->throwError();
    }

    public function testGetContent()
    {
        $body = '{"test":"Order create successful"}';
        $content = 'HTTP/1.1 201 Created' . PHP_EOL . PHP_EOL . $body;
        $httpCode = 201;

        $responseHandler = new ResponseHandler($content, $httpCode);

        $this->assertEquals(json_decode($body, true), $responseHandler->getContent());
    }

    public function testSetHeader()
    {
        $body = '';
        $header = 'HTTP/1.1 201 Created' . PHP_EOL;
        $header .= 'Cache-Control: no-cache' . PHP_EOL;
        $header .= 'Pragma: no-cache' . PHP_EOL;
        $header .= 'Content-Length: 3469' . PHP_EOL;
        $header .= 'Content-Type: application/json; charset=utf-8' . PHP_EOL;
        $header .= 'Expires: -1' . PHP_EOL;
        $header .= 'Server: Microsoft-IIS/8.5' . PHP_EOL;
        $header .= 'X-AspNet-Version: 4.0.30319' . PHP_EOL;
        $header .= 'X-Powered-By: ASP.NET' . PHP_EOL;
        $header .= 'Date: Wed, 27 Apr 2016 09:42:19 GMT';

        $content = $header . PHP_EOL . PHP_EOL . $body;
        $httpCode = 201;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->setHeader();

        $res = array
        (
            'http_code' => 'HTTP/1.1 201 Created',
            'Cache-Control' => 'no-cache',
            'Pragma' => 'no-cache',
            'Content-Length' => '3469',
            'Content-Type' => 'application/json; charset=utf-8',
            'Expires' => '-1',
            'Server' => 'Microsoft-IIS/8.5',
            'X-AspNet-Version' => '4.0.30319',
            'X-Powered-By' => 'ASP.NET',
            'Date' => 'Wed, 27 Apr 2016 09:42:19 GMT'
        );


        $this->assertEquals($res, $responseHandler->getHeader());
    }

    public function testSetBody()
    {
        $body = '{"test":"Order create successful"}';
        $content = 'HTTP/1.1 201 Created' . PHP_EOL . PHP_EOL . $body;
        $httpCode = 200;

        $responseHandler = new ResponseHandler($content, $httpCode);
        $responseHandler->setBody();

        $this->assertEquals($body, $responseHandler->getBody());
    }
}
