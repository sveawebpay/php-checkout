<?php

namespace Svea\Checkout\Transport;

use Svea\Checkout\Exception\SveaApiException;

class ResponseHandler
{
    private $content;

    /**
     * Handle response
     *
     * @param $content
     * @param $httpCode
     * @throws SveaApiException
     */
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

    /**
     * Return error message from json response
     *
     * @param $jsonContent
     * @return string
     */
    private function getResponseErrorMessage($jsonContent)
    {
        $content = json_decode($jsonContent, true);

        if (isset($content['Message'])) {
            return $content['Message'];
        }

        return "Undefined error occurred";
    }


    /**
     * Return response content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
