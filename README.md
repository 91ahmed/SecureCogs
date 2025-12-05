SecureCogs is a PHP data storage package that allows you to store data in an encrypted key-value pair format.

## Features

* Encrypted key-value storage in flat files.
* Customizable encryption algorithm, key, and IV.
* Returns data as PHP array — easy to integrate.
* No external dependencies beyond standard PHP + composer autoload.

#### Composer Installation
``` bash
composer require 91ahmed/secure-cogs
```

#### Usage Example
``` php
require 'vendor/autoload.php';

// Create (or load) a config file (filename without extension)
$config = new \SecureCogs\Cogs("path/to/secure_config");

// Set a new key-value pair
$config->set('key', 'value');

// Update an existing key
$config->edit('key', 'new value');

// Delete a key
$config->delete('key');

// Get all stored data (decrypted)
$data = $config->data();
print_r($data);
```

#### Change the Encryption Algorithm
``` php

$config = new \SecureCogs\Cogs("path\filename");

// Set your own encryption algorithm / key / iv
$config->method('AES-256-CBC');
$config->key('1a2b813c45f1bH13c29d3812d2e0cfd59db438R029f8287d6f231b2T2079b343');
$config->iv('1982538500398210');
```

#### Display the Data in an Array
``` php
	
$config = new \SecureCogs\Cogs("path\filename");

// This method will display the data in its form, without encryption.
print_r($config->data());
```
