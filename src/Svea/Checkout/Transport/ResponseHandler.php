<?php

namespace Svea\Checkout\Transport;

use Svea\Checkout\Exception\SveaApiException;


class ResponseHandler
{
    private $content;

    public function handleClientResponse($content, $httpCode)
    {
        switch ($httpCode) {
            case 200:
            case 201:
            case 302:
                $this->content = $content;
                break;
            default:
                throw new SveaApiException($this->getResponseErrorMessage($content), $httpCode);
                break;
        }
    }

    /* private function handleResponse($httpCode, $content)
     {
         switch ($httpCode) {
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
     }*/

    private function getResponseErrorMessage($jsonContent)
    {
        $content = json_decode($jsonContent, true);

        if (isset($content['Message'])) {
            return $content['Message'];
        }

        return "Undefined error occurred";
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

}