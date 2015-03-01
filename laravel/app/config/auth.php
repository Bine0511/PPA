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
			'table' => 'user',
			'username' => 'user_name',
			'password' => 'user_session_pw'
		)
	),

	'reminder' => array(

		'email' => 'emails.auth.reminder',

		'table' => 'password_reminders',

		'expire' => 60,

	),

);
