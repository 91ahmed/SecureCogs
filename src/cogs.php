<?php
	namespace SecureCogs;

	use SecureCogs\Crypto;

	class Cogs extends Crypto
	{
		private $file;
		private $crypto;
		private $type = 'txt';

		public function __construct (String $file)
		{	
			$this->file = $file.'.'.$this->type;
			$this->crypto = new Crypto();
			$this->checkFile($file);
		}

		/**
		 *	Check if the file exists, and create a new data file in the given path if it does not exists.
		 *
		 *	@param String $file .. The file path
		 *	@return void
		 */
		private function checkFile (String $file)
		{
			if (!is_file($file) || !file_exists($file)) 
			{
				$file = str_replace('.'.$this->type, '', $file);
				$file = explode(DIRECTORY_SEPARATOR, $file);
				$dataFile = end($file);
				array_pop($file);

				$file = implode(DIRECTORY_SEPARATOR, $file);

				if (is_dir($file)) {
		 			$f = $file.DIRECTORY_SEPARATOR.$dataFile.'.'.$this->type;
		 			fopen($f, 'w');
				} else {
		 			$f = $file.DIRECTORY_SEPARATOR.$dataFile.'.'.$this->type;
		 			mkdir($file, 0777, true);
		 			fopen($f, 'w');
				}
			}
			else
			{
				if (pathinfo($file, PATHINFO_EXTENSION) !== $this->type) 
				{
					throw new \Exception("The data file has invalid file extension.", 1);
				}
			}
		}

		/**
		 *	Insert a new row of data with a specified key and encrypted value.
		 *
		 *	@param string $key .. The key to be inserted into the data (e.g., "username", "password")
		 *	@param string $value .. The new value to associate with the given key.
		 *  @return void .. This function does not return a value. It appends the encrypted data to the file if the key does not already exist
		 *
		 *	@throws Exception If the key has an invalid format.
		 *	@throws Exception If there is an error writing to the file or during encryption.
		 */
		public function set (String $key, String $value) 
		{
			if (!preg_match('/^[a-zA-Z0-9_]+$/', $key)) {
				throw new \Exception("The key '$key' has an invalid format. The key must only contain letters (a-z, A-Z), digits (0-9), or underscores (_).");
			}

			if (!array_key_exists($key, $this->data())) 
			{
				$value = (string) $value;
				$key = (string) $key;

				$encryptedValue = $this->crypto->encrypt($value);

				$data = '{'.$key.':'.$encryptedValue."}\n";
				file_put_contents($this->file, $data, FILE_APPEND);
			}
			else 
			{
				throw new \Exception("The key '$key' already exists in the data.");
			}
		}

		/**
		 *	Update the value of a specific key in the data and encrypt the updated values.
		 *
		 *	@param string $key .. The key to be updated in the data (e.g., "username", "password")
		 *	@param string $value .. The new value to set for the given key.
		 *  @return void .. This function does not return a value. It updates the data and writes the encrypted data to a file.
		 *
		 *	@throws Exception If the provided key does not exist in the data.
		 */
		public function edit (String $key, String $value) 
		{
			if (array_key_exists($key, $this->data())) 
			{
				$key = (string) $key;

				$data = $this->data();
				$data[$key] = $value;

				$updated = null;

				foreach ($data as $k => $v) {
					$v = $this->crypto->encrypt($v);
					$data[$k] = $v;
					$updated .= '{'.$k.':'.$v."}\n";
				}

				file_put_contents($this->file, $updated);
			}
			else 
			{
				throw new \Exception("The key '$key' does not exist in the data.");
			}
		}

		/**
		 *	Delete the specified key from the data file.
		 *
		 *	@param String $key
		 *  @return void
		 *
		 *	@throws Exception If the key does not exist in the data.
		 */
		public function delete (String $key) 
		{
			if (array_key_exists($key, $this->data())) 
			{
				$key = (string) $key;

				$data = $this->data();
				unset($data[$key]);

				$updated = null;

				foreach ($data as $k => $v) {
					$v = $this->crypto->encrypt($v);
					$data[$k] = $v;
					$updated .= '{'.$k.':'.$v."}\n";
				}

				file_put_contents($this->file, $updated);
			}
			else 
			{
				throw new \Exception("The key '$key' does not exist in the data.");
			}
		}

		/**
		 *	Display the data as an associative array with keys and values.
		 *
		 *	@return Array
		 */
		public function data () 
		{
			$data = file_get_contents($this->file);
			$data = explode('{', $data);
			$array = [];

			foreach ($data as $value) {
				if (!empty($value)) {
					$d = explode(':', $value, 2);

					$k = $d[0];
					$v = trim(trim($d[1]), '}');
					$v = $this->crypto->decrypt($v);

					$array[$k] = $v;
				}
			}
			
			return $array;
		}

		/**
		 *	Configure a new OpenSSL encryption algorithm.
		 *
		 *	@param String $method (e.g 'AES-256-CBC')
		 * 	@return void
		 */
		public function method (String $method)
		{
			$this->crypto->_method = $method;
		}		

		/**
		 *	Configure a new OpenSSL encryption key.
		 *
		 *	@param String $key (e.g 1a2b813c45f1bH13c29d3812d2e0cfd59db438R029f8287d6f231b2T2079b343)
		 * 	@return void
		 */
		public function key (String $key) 
		{
			$this->crypto->_key = $key;
		}

		/**
		 *	Configure a new OpenSSL encryption iv.
		 *
		 *	@param String $iv (e.g 1982538500398210)
		 * 	@return void
		 */
		public function iv (String $iv) 
		{
			$this->crypto->_iv = $iv;
		}
	}
?>