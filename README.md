SecureCogs is a PHP package for securely storing application data as encrypted key-value pairs, ideal for storing (credentials, secrets, tokens).

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

#### Advanced: Custom Encryption Method
``` php
$config = new \SecureCogs\Cogs("path/to/secure_config");

// Change encryption settings
$config->method('AES-256-CBC');
$config->key('your-very-strong-key-here');
$config->iv('your-initialization-vector');
```
