<?php
/**
 * Created by PhpStorm.
 * User: rs-janstev-01
 * Date: 4/18/2016
 * Time: 3:54 PM
 */

namespace Svea\Checkout\Transport;

use Svea\Checkout\Request\RequestInterface;

class Client
{
    /*
     * Call Api
     *
     * @return ResponseInterface
     * */
    public function call(RequestInterface $request) {

        $ch = curl_init($request->getUrl());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*if($request->getMethod() == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getPostData());
        }*/

        $response = curl_exec($ch);

        return $response;
    }
}


class Request
{
    public function __construct() { }

    public function setHeader() { }

    public function setBody() { }

    public function setMethod() { }
}