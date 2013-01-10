<?php
namespace Tipalti;

/**
 * Main Class takes requests like standard SoapClient using magicc __call method
 * Encryption param, payerName and idap (if provided) are added automatically
 * Did not work when class extended \SoapClient. Tipalti returned errorMessage 'PayerUnknown'
 */
class SoapClient
{
	/**
	 * URI to wsdl file
	 * var string
	 */
	protected $_wsdl;
	
	/**
	 * Configuration object
	 * var Config
	 */
	protected $_config;
	
	/**
	 * SoapClient real object
	 * var SoapClient
	 */
	protected $_client;
	
	
	public function __construct()
	{
		$this->_client = new \SoapClient($this->_wsdl);
		//parent::__construct($this->_wsdl);
	}
	
	/**
	 * Magic method that catches all method calls, adds encryption and returns result itself
	 * 
	 * @param string $functionName
	 * @param array $functionArguments First element should be EAT parameter in array (where key is parameter name),
	 * 								   second element is array of other parameter
	 * @return stdClass
	 */
	public function __call($functionName, $functionArguments)
	{
		$arguments['payerName'] = $this->_config['payerName'];
		if(isset($this->_idap)){
			$arguments['idap'] = $this->_idap;
		}
		$arguments['timestamp'] = time();
		
		//parameter used as EAT "Encryption Additional Terms"
		if(isset($functionArguments[0])){
			$arguments = array_merge($arguments,$functionArguments[0]);
		}

		//generating a key param, encoding acording to documentation			
		$arguments["key"] = hash_hmac("sha256", implode($arguments), $this->_config['secretKey'], false);
		
		//other parameters without EAT
		if(isset($functionArguments[1])){
			$arguments = array_merge($arguments,$functionArguments[1]);
		}		
		//var_dump($arguments);
		
		$mainResult = $this->_client->$functionName($arguments);
		//did not work, same as $this->__soapCall(); 
		//$mainResult = parent::__call($functionName,$arguments);
		$resultName = $functionName.'Result';
		//var_dump($mainResult->$resultName);
		return $mainResult->$resultName;
	}
	
	/**
	 * Allows to get config in childern classes
	 */
	protected function _gainConfig()
	{
		$this->_config = \Config::get('payments.tipalti');
	}
}