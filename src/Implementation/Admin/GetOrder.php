<?php

namespace Svea\Checkout\Implementation\Admin;

use Svea\Checkout\Implementation\Admin\AdminImplementationManager;

class GetOrder extends AdminImplementationManager
{
	protected $apiUrl = '/api/orders/%d';

	/**
	 * Input data validation
	 *
	 * @param mixed $data Input data to Svea Checkout Library
	 */
	public function validateData($data)
	{
		// TODO: Implement validateData() method.
	}

	/**
	 * Prepare body data for Api call
	 *
	 * @param mixed $orderId
	 */
	public function prepareData($orderId)
	{
		$this->requestModel = new Request();
		$this->requestModel->setGetMethod();
		$this->requestModel->setApiUrl($this->connector->getBaseApiUrl() . $this->getUrlString($orderId));
	}

	/**
	 * Invoke Api call
	 */
	public function invoke()
	{
		// TODO: Implement invoke() method.
	}
}