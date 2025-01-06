<?php
	namespace SecureCogs;

	/**
	 *	
	 */
	class Crypto
	{
		protected $_key;
		protected $_method;
		protected $_iv;

		public function __construct () 
		{
			$this->_method = "AES-256-CBC";
			$this->_key    = "5a2b813c45f1b913c29d3812d2e0cfd59db4384029f8287d6f231b2a2079b343";
			$this->_iv     = "1982538500398210";	
		}

		protected function encrypt (String $data) 
		{
			$encrypt = openssl_encrypt($data, $this->_method, $this->_key, OPENSSL_RAW_DATA, $this->_iv);
			$encrypt = base64_encode($encrypt);

			return $encrypt;	
		}

		protected function decrypt (String $data) 
		{
			$decrypt = base64_decode($data);
			$decrypt = openssl_decrypt($decrypt, $this->_method, $this->_key, OPENSSL_RAW_DATA, $this->_iv);

			return $decrypt;
		}
	}
?>