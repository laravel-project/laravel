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
					'app_secret' => 'd47840a0f24e7edbc5206afd4fb16c89',
					'scope' => 'email user_about_me'
				),
				'Twitter' => array(
					'key' 	 => 'APP_KEY',
					'secret' => 'APP_SECRET'
				)			
			),
	    	'security_salt'	=> 'YOURSALTGOESHERE!',
	    	'path' 			=> '/',
	    	'callback_transport' => 'post',
	    	'callback_url'	=> '/login_with_facebook'
		);

		return new Opauth($config);
	});
