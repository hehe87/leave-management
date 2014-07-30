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
            'client_id'     => '1044535373669-8bun0a6rhn0rru7n0sbgp6ht9pktc6k0.apps.googleusercontent.com',
            'client_secret' => '46T0rlXdV_7euGvFG3laeAQb',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

	)

);