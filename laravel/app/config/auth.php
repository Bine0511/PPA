<?php

return array(

	'multi' => array(
		'Mod' => array(
			'driver' => 'eloquent',
			'model' => 'Mod',
			'username' => 'moderator_name',
			'password' => 'moderator_pw'
		),
		'User' => array(
			'driver' => 'eloquent',
			'model' => 'User',
			'username' => 'ppuser_name',
			'password' => 'ppuser_session_pw'
		),
		'PPSession' => array(
			'driver' => 'eloquent',
			'model' => 'PPSession',
			'username' => 'session_name',
			'password' => 'session_pw'
		),
	),

	'reminder' => array(

		'email' => 'emails.auth.reminder',

		'table' => 'password_reminders',

		'expire' => 60,

	),

);
