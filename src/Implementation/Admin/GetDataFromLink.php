<?php


namespace Svea\Checkout\Implementation\Admin;


use Svea\Checkout\Model\Request;

class GetDataFromLink extends AdminImplementationManager
{
    /**
     * Request body - JSON
     *
     * @var Request $requestModel
     */
    private $requestModel;

    /**
     * Input data validation
     * @param mixed $data Input data to Svea Checkout Library
     */
    public function validateData($url)
    {
        $this->validator->validate($url);
    }

    /**
     * Prepare body data for Api call
     * @param mixed $url
     */
    public function prepareData($url)
    {
        $this->requestModel = new Request();
        $this->requestModel->setGetMethod();
        $this->requestModel->setApiUrl($this->connector->getBaseApiUrl().$url);
    }

    /**
     * Invoke Api call
     */
    public function invoke()
    {
        $this->response = $this->connector->sendRequest($this->requestModel);
    }
}