SecureCogs is a PHP data storage package that allows you to store data in an encrypted key-value pair format, providing various methods to simplify data accessibility and maintainability.

#### Composer Installation
``` bash

```

#### Example
``` php

require ('vendor/autoload.php');

// Set the path to the config file.
// The filename should not include an extension.
$config = new \SecureCogs\Cogs("path\filename");

// Set new data.
$config->set('key', 'value');
// Edit the value of an existing key.
$config->edit('key', 'new value');
// Delete existing key.
$config->delete('key');
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