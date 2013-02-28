<?php

	Autoloader::map(array(
	   'Opauth' => __DIR__.'/Opauth/Opauth.php',
	));

	Laravel\IoC::singleton('opauth', function()
	{
	    $config = array(
			'Strategy' => array(
				'Facebook' => array(
					'app_id' 	 => '604721692878709',
					'app_secret' => '1be4abae6ed640890ea66d3a34e0112b'
				),
				'Twitter' => array(
					'key' 	 => 'APP_KEY',
					'secret' => 'APP_SECRET'
				)			
			),
	    	'security_salt'	=> 'YOURSALTGOESHERE!',
	    	'path' 			=> '/',
	    	'callback_transport' => 'get',
	    	'callback_url'	=> '/login_with_facebook'
		);

		return new Opauth($config);
	});
