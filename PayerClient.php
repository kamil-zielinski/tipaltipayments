<?php
namespace Tipalti;

/**
 * Sets proper wsdl automatically for Tipalti\SoapClient
 *
 */
class PayerClient extends SoapClient
{
	public function __construct()
	{
		$this->_gainConfig();
		$this->_wsdl = $this->_config['payerWsdl'];
		parent::__construct();
	}
}