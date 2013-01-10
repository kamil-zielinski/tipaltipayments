<?php
namespace Tipalti;

/**
 * Sets proper wsdl automatically for Tipalti\SoapClient
 * Requires user idap to be set
 *
 */
class PayeeClient extends SoapClient
{
	
	/**
	 * User identifier
	 * var string
	 */
	protected $_idap;	
	
	public function __construct($idap)
	{
		$this->_idap = $idap;
		$this->_gainConfig();
		$this->_wsdl = $this->_config['payeeWsdl'];
		parent::__construct();
	}
}