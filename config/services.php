<?php
return [
	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],
	'mandrill' => [
		'secret' => getenv('MANDRILL_API'),
	],
	'faithlife' => [
		'token'  => getenv('CONSUMER_TOKEN'),
		'secret' => getenv('CONSUMER_SECRET'),
	],
	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],
	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],
	'facebookAppId'=>'1529479753993292'
];