<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Google
		 */
        'Google' => array(
            'client_id'     => '435313904512-4elr5moook4ardtq8dgbmrl48i0mh9in.apps.googleusercontent.com',
            'client_secret' => 'ROK1YzOaAAdJyoJ2O_OM7dq1',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

	)

);