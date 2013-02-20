<?php

return array(

	// Debug mode will echo connection status alerts to
	// the screen throughout the email sending process.
	// Very helpful when testing your credentials.
	
	'debug_mode' => true,
	
	// Define the different connections that can be used.
	// You can set which connection to use when you create
	// the SMTP object: ``$mail = new SMTP('my_connection')``.

	'default' => 'primary',
	'connections' => array(
		'primary' => array(
			'host' => 'smtp.gmail.com',
			'port' => 465,
			'secure' => 'ssl', // null, 'ssl', or 'tls'
			'auth' => true, // true if authorization required
			'user' => 'developer.laravel@gmail.com',
			'pass' => 'laravel123',
		),
	),

);
