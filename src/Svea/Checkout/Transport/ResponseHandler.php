<?php

namespace Svea\Checkout\Transport;

use Svea\Checkout\Transport\Exception\SveaApiException;

class ResponseHandler
{
    private $content;

    public function handleClientResponse($content, $responseInfo, $error)
    {
        if ($error !== '') {
            throw new SveaApiException($error, 1011);
        } else {
            $this->handleStatusCodes($responseInfo, $content);
        }
    }

    private function handleStatusCodes($responseInfo, $content)
    {
        // TODO - finish statuses
        $statusCode = $responseInfo['http_code'];

        switch ($statusCode) {
            case 200:
            case 201:
            case 302:
                $this->content = json_decode($content, true);
                break;
            case 400:
                $error = 'The input data was bad';
                throw new SveaApiException($error, 1000);
                break;
            case 401:
                $error = 'Unauthorized: Missing or incorrect Authorization token in header. ' .
                    'Please verify that you used the correct Merchant ID and Shared secret when you constructed your client.';
                throw new SveaApiException($error, 1001);
                break;
            case 404:
                $error = 'No order with requested ID was found.';
                throw new SveaApiException($error, 1004);
                break;
            default:
                $error = 'Undefined error.';
                throw new SveaApiException($error, 1005);
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

}