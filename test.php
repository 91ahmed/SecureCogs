<?php
	require ('vendor/autoload.php');


	$config = new \SecureCogs\Cogs(__DIR__.'\config\app');

	// You can set your own encryption algorithm
	$config->method('AES-256-CBC');
	$config->key('1a2b813c45f1bH13c29d3812d2e0cfd59db438R029f8287d6f231b2T2079b343');
	$config->iv('1982538500398210');

	$config->set('domain', 'https://www.example.com');
	$config->set('user', 'mido gaber');
	$config->set('name', 'Ahmed Hassan');
	$config->set('age', '33 or 55');
	$config->set('email', 'ahmedh12491@gmail.com');

	$config->edit('name', 'Omar Kamal');

	$config->delete('age');

	var_dump($config->data());
?>